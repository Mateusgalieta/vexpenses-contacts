<?php

namespace App\Repositories\Contracts;

use App\Models\Usuario;
use Illuminate\Support\Collection;
use App\Repositories\BaseRepositoryInterface;

/**
 * Interface UsuarioRepository
 * @package namespace App\Repositories;
 */
interface UserRepository extends BaseRepositoryInterface
{
    public function idsFluxosAprovacaoUsuarioLogado();
    public function possiveisAprovadoresDeUmFluxo($idFluxo);
    public function newOmieMember($member);
    public function findByIntegrationToken($domainFrom, $token);
    public function searchNotInCostCenter($idCostCenter);
    public function searchNotInLimitExpense($idLimitExpense);
    public function searchNotInProject($idProject);
    public function searchInProject($idProject);
    public function searchNotInRouteLimit($idRouteLimit);
    public function pesquisarUsuarios($nome);
    public function getUsuariosSemCentroCusto(int $idEmpresa);
    public function getUsuariosSemProjeto();
    public function countAdmin();
    public function usuariosIntegrados(string $integracao): Collection;
    public function usuariosNaoIntegrados(int $idIntegracao, bool $considerarUsuarioPossuiDespesa = false): Collection;
    public function scopeIdsUsuariosEmpresa($query, $idEmpresa);
    public function getInvoiceUsers(int $idEmpresa, string $dataInicial, string $dataFinal);
}
