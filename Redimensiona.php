<?php
    
    if($_FILES){
        if (isset($_FILES['imagem']['name'])) {
            $caminho_das_imagens = 'imagens/';
            $nomeImagem = 'clima_img';
            $redim = new Redimensiona();
            $src=$redim->Redimensionar($nomeImagem, $_FILES['imagem'], $_POST['largura'], $caminho_das_imagens);
            echo $src;
        } else {
            echo 'OOps';
        }
    }
   class Redimensiona{
	
        public function Redimensionar($nomeImagem, $imagem, $largura, $pasta){
            $md5 = md5(time().$imagem['name']);
            $name = $nomeImagem.$md5;
            
            if ($imagem['type']=="image/jpeg"){
                $img = imagecreatefromjpeg($imagem['tmp_name']);
            }else if ($imagem['type']=="image/gif"){
                $img = imagecreatefromgif($imagem['tmp_name']);
            }else if ($imagem['type']=="image/png"){
                $img = imagecreatefrompng($imagem['tmp_name']);
            }
            $x   = imagesx($img);
            $y   = imagesy($img);
            $altura = (int)(($largura * $y)/$x); // Cast the result to an integer
            
            $nova = imagecreatetruecolor($largura, $altura);
            
            // Set the background of the PNG image to be transparent
            imagealphablending($nova, false);
            imagesavealpha($nova, true);
            $transparent = imagecolorallocatealpha($nova, 0, 0, 0, 127);
            imagefill($nova, 0, 0, $transparent);
            
            imagecopyresampled($nova, $img, 0, 0, 0, 0, $largura, $altura, $x, $y);
            
            if ($imagem['type']=="image/jpeg"){
                $local="$pasta$name".".jpg";
                imagejpeg($nova, $local);
            }else if ($imagem['type']=="image/gif"){
                $local="$pasta$name".".gif";
                imagejpeg($nova, $local); // Corrected to save as gif
            }else if ($imagem['type']=="image/png"){
                $local="$pasta$name".".png";
                imagepng($nova, $local); // Corrected to save as png
            }		
            
            imagedestroy($img);
            imagedestroy($nova);	
            
            return $local;
        }
    }
?>