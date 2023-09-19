<?php
//document in b,kb,mb etc
function convert_filesize($bytes, $decimals = 2)

    {
        $size = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
    }

// hoofdmap ophalen
    $cwd = getcwd();


// checken of cwd er is:
    if (isset($_GET['cwd'])) {
        $cwd = $_GET ['cwd'];
    }
// path opschonen
    $cwd = realpath($cwd);

// alle bestanden en mappen ophalen
    $all = scandir($cwd);

// path als link maken
$crumbs = str_replace(getcwd(), "", $cwd);   //vervangt cwd, cwd laat het path zien
$crumbs = ltrim($crumbs, DIRECTORY_SEPARATOR); // ltrim haalt linker kant van de string weg, DS maakt het gangbaar voor (mac en of windows)
$crumbs = explode(DIRECTORY_SEPARATOR, $crumbs); // explode split DS ne crumb.

// one liner:
$crumbs = explode(DIRECTORY_SEPARATOR, ltrim(str_replace(getcwd(), "", $cwd), DIRECTORY_SEPARATOR));

$link = getcwd();
echo '<a href="index.php">home</a> ' . DIRECTORY_SEPARATOR . " ";
foreach ($crumbs as $crumb) {
    $link .= DIRECTORY_SEPARATOR . $crumb;
    echo '<a href="index.php?dir=' . $link . '">' . $crumb . '</a> ' . DIRECTORY_SEPARATOR . " ";
}
echo "<br>";

// eerste twee elemeneten er af halen . en ..
    $all = array_splice($all, 2);
    echo $cwd . "<hr>";


    foreach ($all as $a) {

        // onderscheid bestanden en mappen
        if (is_file($cwd . '/' . $a)) {
            echo '[F] <a href="index.php?cwd=' . $cwd . '&file=' . $a . '">' . $a . '</a><br>';
//        echo "<br>";
        } else {
            echo '[D] <a href="index.php?cwd=' . $cwd . '/' . $a . '">' . $a . '</a><br>';
//        echo "<br>";
        }
    }

    if (isset($_GET['file'])) {
        //echo "Bestand aangeklikt.";
        $file = $_GET['file'];
        $full_path = $cwd . '/' . $file;


//echo $full_path;

        echo "<br>";
        echo convert_filesize(filesize($full_path)) . "<br>";
        echo date("d F Y @ H:i:s", filemtime($full_path)) . "<br>";
        if (is_writeable($full_path)) {
            echo "Aanpasbaar<br>";
        } else {
            echo "Niet schrijfbaar<br>";
        }

// mimetype:
        $type = explode('/', mime_content_type($full_path))[0];
        //echo $type;

        if ($type == "image") {
            //echo $full_path . "<br>";
            //echo getcwd() . "<br>";
            $img_path = str_replace(getcwd(), "", $full_path);
            $img_path = ltrim($img_path, '/');

            echo '<img src="' . $img_path . '" alt="">';




        }
    }

