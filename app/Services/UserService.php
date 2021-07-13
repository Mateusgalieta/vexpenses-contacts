<?php

namespace App\Services;

use DB;
use Throwable;
use Carbon\Carbon;
use App\Models\Fatura;
use App\Models\Empresa;
use App\Models\Registro;
use App\Mail\FaturaMensal;
use App\Events\BillWasPaid;
use App\Models\EmpresasPlano;
use App\Events\BillWasCancelled;
use Illuminate\Support\Facades\Mail;
use App\Events\BillTaxReceiptWasAdded;
use App\Services\Responses\ServiceResponse;
use App\Repositories\Contracts\UserRepository;
use App\Repositories\Contracts\FaturaRepository;
use App\Services\Contracts\IuguServiceInterface;
use App\Services\Contracts\UserServiceInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserService extends BaseService implements UserServiceInterface
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * @param UserRepository $faturaRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Traz uma fatura pelo id
     *
     * @param  int|string $id
     *
     * @return ServiceResponse
     */
    public function find($id): ServiceResponse
    {
        try {
            $fatura = $this->faturaRepository->find($id);
        } catch (ModelNotFoundException $e) {
            return new ServiceResponse(
                false,
                trans('services/fatura.invoice_not_found')
            );
        } catch (Throwable $e) {
            return $this->defaultErrorReturn(
                $e,
                compact('id'),
                $id
            );
        }

        return new ServiceResponse(
            true,
            trans('services/fatura.invoice_found_successfully'),
            $fatura
        );
    }
}
