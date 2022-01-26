<?php 

	class Painel
	{

		//transforma tudo de acento em letra normal sem acentuação e espaços e coisas como ?,! sao subistituido com -
		public static function generateSlug($str){
			$str = mb_strtolower($str);
			$str = preg_replace('/(â)|(á)|(ã)/', 'a', $str);
			$str = preg_replace('/(ê)|(é)/', 'e', $str);
			$str = preg_replace('/(í)|(Í)/', 'i', $str);
			$str = preg_replace('/(ú)/', 'u', $str);
			$str = preg_replace('/(ó)|(ô)|(õ)|(Ó)/', 'o', $str);
			$str = preg_replace('/(ç)/', 'c', $str);
			$str = preg_replace('/(_|\/|!|\?|#)/', '', $str);
			$str = preg_replace('/( )/', '-', $str);
			$str = preg_replace('/-[-]{1,}/', '-', $str);
			$str = preg_replace('/(,)/', '-', $str);
			$str = strtolower($str);
			return $str;
		}


		public static function logado(){
			return isset($_SESSION['login']) ? true : false;
		}

		public static function SairDaSessao(){
			setcookie('lembrar','true',time()-1,'/');//a / serve para pegar em todo o site
			session_destroy();//destroi toda a minha session
			header('Location: '.INCLUDE_PATH_PAINEL);//me redireciona para fazer o login
		}


		//pagina do painel 'home'
		public static function CarregarPage(){
			if(isset($_GET['url'])){
				$url = explode('/',$_GET['url']);
				if(file_exists('pages/'.$url[0].'.php')){
					include('pages/'.$url[0].'.php');
				}else{
					//caso a pagina nao exista

					header('Location: '.INCLUDE_PATH_PAINEL);
					
					//esse da certo mas nao limpa a url
					//include('../painel/pages/home.php');
				}
			}else{
				include('../painel/pages/home.php');
			}
		}

		public static function listarUsuariosOnline(){
			self::limparUsuariosOnline();
			
			$sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.online`");
			$sql->execute();
			return $sql->fetchAll();

		}

		public static function limparUsuariosOnline(){
			$data = date('Y-m-d H:i:s');
			$sql = MySql::conectar()->exec("DELETE FROM `tb_admin.online` WHERE ultima_acao < '$data' - INTERVAL 1 MINUTE ");
		}

		public static function VisitasTotais(){
			$sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.visitas` ");
			$sql->execute();
			return $sql->rowCount();
		}

		public static function VisitasHoje(){
			$sql = MySql::conectar()->prepare("SELECT * FROM `tb_admin.visitas` WHERE dia = ?");
			$sql->execute(array(date('Y-m-d')));
			return $sql->rowCount();
		}

		public static function AtualizarAlerta($tipo,$mensagem){
			if($tipo == 'sucesso'){
				echo'<div class="atualizado-sucesso">'.$mensagem.'</div>';
			}else if($tipo == 'erro'){
				echo'<div class="atualizado-erro">'.$mensagem.'</div>';
			}
		}

		public static function imagemValida($imagem){
			if($imagem['type'] == 'image/jpeg' || $imagem['type'] == 'imagem/jpg' || $imagem['type'] == 'imagem/png'){
				
				$tamanho = intval($imagem['size']/1024);//vai deixar ele em kbite e vai arredondar para inteiro

				if($tamanho < 300){
					return true;
				}else {
					return false;
				}

			}else{
				return false;
			}
		}

		public static function updateImage($file){
			//para resolver o problema de mesmo nome com uma imagem
			$formatoImagem = explode('.',$file['name']);
			$imagemNome= uniqid().'.'.$formatoImagem[count($formatoImagem) - 1];
			if(move_uploaded_file($file['tmp_name'],BASE_DIR_PAINEL.'/uploades/'.$imagemNome)){
				return $imagemNome;
			}else{
				return false;
			}
		}

		public static function deleteImagem($file){
			@unlink('uploades/'.$file);//deleta a imagem atual e nao retorna erro com @
		}
		
		//sistema de permisao e tem no confg
		static $cargos = [
			'0' => 'Normal',
			'1' => 'Regalias',
			'2' => 'Administrador',
		];

		//para cadastrar os depoimentos e os slides mas nao irei mudar o nome
		public static function IncerirDepoimento($arr){
			$certo = true;
			$nomeTabela = $arr['nome_tabela'];
			$query = "INSERT INTO `$nomeTabela` VALUES (null";
			foreach ($arr as $key => $value) {
				$nome = $key;
				$valor = $value;

				if($nome == 'acao' || $nome == 'nome_tabela'){
					continue;
				}

				if($valor == ''){
					$certo = false;
					break;
				}

				$query.=",?";
				$parametros[] = $value;
			}

			$query.=")";
			if($certo == true){
				$sql = MySql::conectar()->prepare($query);
				$sql->execute($parametros);
				$last_id = MySql::conectar()->lastInsertId();
				$sql = MySql::conectar()->prepare("UPDATE `$nomeTabela` SET order_id = ? WHERE id = $last_id");
				$sql->execute(array($last_id));

			}
			
			return $certo;
		}

		//pegar os depoimentos e mostrar na pagina e tbm os servicos
		public static function SelectAll($tabela,$start = null, $end = null){
			if($start == null && $end == null){
				$sql = MySql::conectar()->prepare("SELECT * FROM `$tabela` ORDER BY order_id ASC");
			}else{
				$sql = MySql::conectar()->prepare("SELECT * FROM `$tabela` ORDER BY order_id ASC LIMIT $start,$end");
			}
			
			$sql->execute();
			return $sql->fetchAll();
		}

		//para cadastrar os servicos e selecionar
		public static function InserirServicos($arr){
			$certo = true;
			$nome_tabela = $arr['nome_tabela'];
			$query = "INSERT INTO `$nome_tabela` VALUES(null";

			foreach ($arr as $key => $value) {
				$nome = $key;
				$valor = $value;

				if($nome == 'acao' || $nome == 'nome_tabela'){
					continue;
				}

				if($valor == ''){
					$certo = false;
					break;
				}

				$query.=",?";
				$parametros[] = $value;
			}
			$query.=")";
			if($certo == true){
				$sql = MySql::conectar()->prepare($query);
				$sql->execute($parametros);
				$last_id = MySql::conectar()->lastInsertId();
				$sql = MySql::conectar()->prepare("UPDATE `$nome_tabela` SET order_id = ? WHERE id = $last_id");
				$sql->execute(array($last_id));
			}

			return $certo;
		}

		public static function update($arr,$single = false){
			$certo = true;
			$first = true;
			$nome_tabela = $arr['nome_tabela'];
			$query = "UPDATE `$nome_tabela` SET ";

			foreach ($arr as $key => $value) {
				$nome = $key;
				$valor = $value;
				if($nome == 'acao' || $nome == 'nome_tabela'){
					continue;
				}

				if($valor == ''){
					$certo = false;
					break;
				}

				if($first == true){
					$first = false;
					$query.="$nome=?";
				}else{
					$query.=",$nome=?";
				}

				$parametros[] = $valor;
			}

			if($certo == true){
				if($single == false){
					$parametros[] = $arr['id'];
					$sql = MySql::conectar()->prepare($query.' WHERE id = ?');
					$sql->execute($parametros);
				}else{
					$sql = MySql::conectar()->prepare($query);
					$sql->execute($parametros);
				}
			}


			return $certo;
		}

		//para deletar meu depoimentos ou meus servicos
		public static function deletar($tabela, $id = false){
			if($id == false){
				$sql = MySql::conectar()->prepare("DELETE FROM `$tabela`");
			}else{
				$sql = MySql::conectar()->prepare("DELETE FROM `$tabela` WHERE id = $id");
			}

			$sql->execute();
		}

		//vai me retornar só um valor selecionado
		public static function select($tabela, $query = '', $arr){
			if($query != false){
				$sql = MySql::conectar()->prepare("SELECT * FROM `$tabela` WHERE $query");
				$sql->execute($arr);
			}else{
				$sql = MySql::conectar()->prepare("SELECT * FROM `$tabela`");
				$sql->execute();
			}

			return $sql->fetch();
		}

		//ordena as listas do painel
		public static function ordemItem($tabela,$ordemTipo,$idItem){
			if($ordemTipo == 'up'){
				//para cima
				$infoItemAtual = Painel::select($tabela,'id=?', array($idItem));
				$orderItem = $infoItemAtual['order_id'];
				$itemBefore = MySql::conectar()->prepare("SELECT * FROM `$tabela` WHERE order_id < $orderItem ORDER BY order_id DESC LIMIT 1");
				$itemBefore->execute();
				if($itemBefore->rowCount() == 0){
					return;
				}
				$itemBefore = $itemBefore->fetch();
				Painel::update(array('nome_tabela'=>$tabela,'id'=>$itemBefore['id'],'order_id'=>$infoItemAtual['order_id']));
				Painel::update(array('nome_tabela'=>$tabela,'id'=>$infoItemAtual['id'],'order_id'=>$itemBefore['order_id']));
			}else if($ordemTipo == 'down'){
				//para baixo
				$infoItemAtual = Painel::select($tabela,'id=?',array($idItem));
				$orderItem = $infoItemAtual['order_id'];
				$itemBefore = MySql::conectar()->prepare("SELECT * FROM `$tabela` WHERE order_id > $orderItem ORDER BY order_id ASC LIMIT 1");
				$itemBefore->execute();
				if($itemBefore->rowCount() == 0){
					return;
				}
				$itemBefore = $itemBefore->fetch();
				Painel::update(array('nome_tabela'=>$tabela,'id'=>$itemBefore['id'],'order_id'=>$infoItemAtual['order_id']));
				Painel::update(array('nome_tabela'=>$tabela,'id'=>$infoItemAtual['id'],'order_id'=>$itemBefore['order_id']));
			}
		}
	}

?>