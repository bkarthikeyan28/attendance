<?php
include('connections.php');
shell_exec('sudo chmod -R 777 /home/ubuntu/Maildir/');
require_once('MimeMailParser.class.php');
$files = scandir('/home/ubuntu/Maildir/new/');
foreach($files as $file) {
        if($file == '.' || $file == '..') continue;
        $p = '/home/ubuntu/Maildir/tmp/'.$file;
        $path = '/home/ubuntu/Maildir/new/'.$file;
        $Parser = new MimeMailParser();
        $Parser->setPath($path);
        $to = $Parser->getHeader('to');
        $from = $Parser->getHeader('from');
        $subject = $Parser->getHeader('subject');
        $text = $Parser->getMessageBody('text');
        $html = $Parser->getMessageBody('html');
        echo $text;
        //$attachments = $Parser->getAttachments(); No Attachments
        shell_exec('sudo rm $path');
}
?>
