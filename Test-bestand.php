?php
if ($_SERVER['REQUEST_METHOD'] ==="POST"){
$file_content = $_POST['file_content'];
file_put_contents("opdracht17.txt", $file_content);
echo "File saved";

}
$file_content = file_get_contents("opdracht17.txt");
file_put_contents("copyopdracht17.txt" , $file_content);
?>

<form method="post" action="opdracht161718.php">
    <textarea rows="10" name="file_content"></textarea>
    <input type="submit" name="opslaan">
</form>
