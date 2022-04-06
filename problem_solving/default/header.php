<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Current Theme </title>
    <!-- iniCustom -->
    <link rel="canonical" href="<?php echo get_site_url() ?>">
    <link rel="canonical" href="<?php echo get_link_url() ?>">
    <?php
    add_action('wp_head', 'show_template');
    function show_template()
    {
        global $template;
        print_r($template);
    }
    ?>
    <!-- iniCustom -->

</head>

<body>

</body>

</html>