<?php

require '../vendor/autoload.php';

// I CREATE YOU. JUST TO DESTROY YOU :3
session_start();
session_destroy();

header('Location: ' . Skuxlife\System::getURL());
