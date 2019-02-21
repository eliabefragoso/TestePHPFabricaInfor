
<?php  
        ini_set("display_errors", 1);
        error_reporting(E_ALL);
        
        include('DB.class.php');   
        $categorias = DB::getConn()->prepare('select * from categorias;');
        $categorias->execute();

        if(isset($_SERVER['REQUEST_METHOD']) AND $_SERVER['REQUEST_METHOD'] == 'POST'){
							
            extract($_POST);
            
            echo '<h3>';
                                        
            if($titulo == '' OR strlen($titulo)<4){
                echo 'Escreva o titulo de sua nota corretamente';
            }elseif($nota=='' OR strlen($nota)<6){
                echo 'Escreva sua nota corretamente';
            }else{
                
               // include('classes/DB.class.php');
                
                try{
                                                
                 
                        $inserir = DB::getConn()->prepare("INSERT INTO `notas` SET `titulo`=?, `nota`=?, `categoria_id`=?");
                        
                        if($inserir->execute(array($titulo,$nota,$categoria_id))){
                            header('Location: ./');
                        }
                    
                
                }catch(PDOException $e){
                    echo 'Sistema indisponível';
                    logErros($e);
                }
            }
            echo '</h3>';
        }						 


        
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Nota Titulo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="estilo.css" />
    <script src="main.js"></script>
</head>
<body>

<form name="cadastro" action="" method="post">
<label for="TituloNota">Titulo:</label>
<input type="text" name="titulo" /> <br/> <br/>
<label for="Nota">Nota:</label>  <br/>
<textarea name="nota" id="nota"> Escreva Sua Nota</textarea>  <br/> 
<label for="CategoriaNota">Categoria:</label>


<select name="categoria_id">
<?php 
     
      while ($cat = $categorias->fetch(PDO::FETCH_ASSOC))  {
	   
         echo  "<option value='".$cat['id']."'>".$cat['categoria']."</option>";
      }
  ?>         
</select> <br/> <br/>

<input type="submit" value="salvar"/> <br/> <br/> <br/> 
</form>
<h1> Suas Notas: </h1>
<?php 
 $notas = DB::getConn()->prepare('select N.titulo, N.nota, C.categoria FROM notas N INNER JOIN categorias C ON C.id = N.categoria_id;');
  $notas->execute(); 
  while ($n = $notas->fetch(PDO::FETCH_ASSOC))  {
	   
?>
<hr> 
<table class="tg">
  <tr>
    <th class="tg-uxdp">Titulo: <?php echo $n['titulo']; ?> </th>
  </tr>
  <tr>
    <td class="tg-oe15">Nota: <?php echo $n['nota']; ?> </td>
  </tr>
  <tr>
    <td class="tg-zv4m">Categoria: <?php echo $n['categoria']; ?></td>
  </tr>
</table> 
<hr> 

<?php } ?>
<script src="js/jquery-3.2.1.min.js"> </script>
<script src="ckeditor/ckeditor.js"></script>
<script src="ckeditor/adapters/jquery.js"></script>
<script>
$( document ).ready( function() {
	$( 'textarea#nota' ).ckeditor();
} );


	
	
</script>

</body>
</html>
