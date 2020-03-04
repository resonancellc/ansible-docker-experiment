<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Front-end 1</title>
</head>
<body>
    <table>
        <tr>
            <td>Server</td><td><?php echo getenv('SERVICE_HOST');?></td>
        </tr>
<?php
$headers = apache_request_headers();
foreach ($headers as $key => $value) {?>
        <tr><td><?php echo $key;?></td><td><?php echo $value ;?></td></tr>
<?php    
}
?>                
    </table>
    <button onclick="callAPI();">Call API</button>
    <script>
        function callAPI(){
            fetch('<?php echo getenv('SERVICE_API_URL');?>')
              .then((response) => {
                return response.json();
              })
              .then((data) => {
                console.log(data);
              });            
        }
    </script>
</body>

</html>