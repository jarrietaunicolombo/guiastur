<?php
interface IEmailSender {
    public function send(EmailDestinationModel $request) : string;
} 

