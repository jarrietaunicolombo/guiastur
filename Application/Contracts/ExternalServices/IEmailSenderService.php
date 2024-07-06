<?php
interface IEmailSenderService {
    public function send(EmailDestinationModel $request) : string;
} 

