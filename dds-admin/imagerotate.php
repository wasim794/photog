<?php
ini_set("display_errors", 1);
error_reporting(E_ALL);

$uploadPath = "uploads/";
// $filename = strtolower($_GET['filename']);
$filename = $_GET['filename'];
echo '<script>console.log("' . $filename . '");</script>';
?>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<div class="img-preview">
    <button id="rleft"><img src="https://img.icons8.com/material-sharp/24/000000/rotate-right.png" /></button>
    <div id="imgPreview">
        <img src="uploads/<?php echo $filename."?_=".time(); ?>" class="pic-view" width="300" height="300" />'
    </div>
    <button id="rright"><img src="https://img.icons8.com/material-sharp/24/000000/rotate-left.png" /></button>

</div>
<form method="post" action="imagerotate.php?filename=<?php echo $filename; ?>" enctype="multipart/form-data">
    <input type="hidden" name="rotation" id="rotation" value="0" />
    <input type="submit" name="submit" id="save" value="Save" />
</form>
<script>
    $(function() {
        var rotation = 0;
        $("#rright").click(function() {
            rotation = (rotation - 90) % 360;
            $(".pic-view").css({
                'transform': 'rotate(' + rotation + 'deg)'
            });

            if (rotation != 0) {
                $(".pic-view").css({
                    'width': '300px',
                    'height': '300px'
                });
            } else {
                $(".pic-view").css({
                    'width': '300px',
                    'height': '300px'
                });
            }
            $('#rotation').val(rotation);
        });

        $("#rleft").click(function() {
            rotation = (rotation + 90) % 360;
            $(".pic-view").css({
                'transform': 'rotate(' + rotation + 'deg)'
            });

            if (rotation != 0) {
                $(".pic-view").css({
                    'width': '300px',
                    'height': '300px'
                });
            } else {
                $(".pic-view").css({
                    'width': '300px',
                    'height': '300px'
                });
            }
            $('#rotation').val(rotation);
        });
    });
</script>

<?php
if (isset($_POST['submit'])) {

    //$fileType = pathinfo($filename)['extension'];
    $mimeType = mime_content_type($uploadPath . $filename);
    
    switch ($mimeType) {
        case 'image/png':
            $fileType = "png";
            break;
        case 'image/gif':
            $fileType = "gif";
            break;
        default:
            $fileType ="jpg";
    }
    

    $rotation = $_POST['rotation'];
    if ($rotation == -90 || $rotation == 270) {
        $rotation = 90;
    } elseif ($rotation == -180 || $rotation == 180) {
        $rotation = 180;
    } elseif ($rotation == -270 || $rotation == 90) {
        $rotation = 270;
    }
    echo '<script>console.log("' . $rotation . '");</script>';

    switch ($fileType) {
        case 'png':
            $source = imagecreatefrompng($uploadPath . $filename);
            break;
        case 'gif':
            $source = imagecreatefromgif($uploadPath . $filename);
            break;
        default:
            $source = imagecreatefromjpeg($uploadPath . $filename);
    }
    
    $imageRotate = imagerotate($source, $rotation, 0);
    echo '<script>console.log("Image: '.$imageRotate.'");</script>';

    switch ($fileType) {
        case 'png':
            $upload = imagepng($imageRotate, $uploadPath . $filename);
            break;
        case 'gif':
            $upload = imagegif($imageRotate, $uploadPath . $filename);
            break;
        default:
            $upload = imagejpeg($imageRotate, $uploadPath . $filename);
    }
    echo '<script>console.log("Upload: '.$upload.'");</script>';
    imagedestroy($source);
    imagedestroy($imageRotate);
    echo '<script>console.log("Complete");</script>';
}
?>