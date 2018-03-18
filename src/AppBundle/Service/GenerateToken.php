<?php

namespace AppBundle\Service;

class GenerateToken
{
    public function generateToken()
    {
        //Retourne une token généré aléatoirement
        return bin2hex(random_bytes(16));
    }
}