<?php

interface productimp_Controllers_Interfaces_iController
{
    public function list(WP_REST_Request $request): Array;
}