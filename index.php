<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redimensionamento de Imagem</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .form {
            max-width: 400px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="file"],
        input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        input[type="button"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="button"]:hover {
            background-color: #45a049;
        }

        #download-btn {
            display: none;
            margin-top: 10px;
        }
    </style>
</head>

<body>

    <div class="form" id="image-form">
        
        <label for="imagem">Selecione uma Imagem:</label>
        <input type="file" id="imagem" name="imagem" accept="image/jpeg, image/gif, image/png" required>

        <label for="largura">Largura da Imagem (em pixels):</label>
        <input type="number" id="largura" name="largura" min="1" required>

        <input type="button" id="submit-btn" value="Redimensionar Imagem">
    </div>

    <button id="download-btn">Baixar Imagem Redimensionada</button>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $('#submit-btn').click(function() {
            var imagem = $('#imagem').prop('files')[0];
            var nomeImagem = $('#nomeImagem').val();
            var largura = $('#largura').val();
            var form_data = new FormData();
            form_data.append('imagem', imagem);
            form_data.append('nomeImagem', nomeImagem);
            form_data.append('largura', largura);
            $.ajax({
                url: 'Redimensiona.php', // point to server-side PHP script 
                dataType: 'text', // what to expect back from the PHP script, if anything
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                type: 'post',
                success: function(data) {
                    console.log(data); // display response from the PHP script, if any
                    downloadImage(data);
                    excluirImagem(data);
                }
            });
        })

        function downloadImage(imageUrl) {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', imageUrl, true);
            xhr.responseType = 'blob';

            xhr.onload = function() {
                if (xhr.status === 200) {
                    var blob = xhr.response;
                    var url = window.URL.createObjectURL(blob);

                    var a = document.createElement('a');
                    a.href = url;
                    a.download = 'imagem';
                    document.body.appendChild(a);
                    a.click();

                    window.URL.revokeObjectURL(url);
                }
            };

            xhr.send();
        }
        // function nomeFromPath(path){
        //     return path.substr(path.lastIndexOf('/') + 1)
        // }
        function excluirImagem(path){
           
            $.ajax({
                url: 'ExcluirImagem.php',
                type: 'DELETE',
                data:{
                    nomeDaImagem: path,
                },
                success: function(response){
                    console.log(response);
                },
                error: function(xhr,status,error){
                    console.log(xhr.responseText);
                }
            })
        }
    </script>

</body>

</html>