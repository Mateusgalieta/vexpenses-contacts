<?php

namespace App\Services\Contracts;

use App\Services\Responses\ServiceResponse;
use App\Services\Params\Usuario\RegisterServiceParams;
use App\Services\Params\Usuario\CreateUserServiceParams;
use App\Services\Params\Usuario\CreateTeamMemberServiceParams;
use App\Services\Params\Usuario\RelatorioDadosUsuariosDaEmpresaServiceParams;

interface UserServiceInterface
{
    public function find($idUsuario): ServiceResponse;
}
