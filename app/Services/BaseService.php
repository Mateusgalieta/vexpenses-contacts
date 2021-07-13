<?php

namespace App\Services;

use Throwable;
use App\Models\Registro;
use Illuminate\Support\Str;
use App\Services\Responses\ServiceResponse;

class BaseService
{
    /**
     * Retorno de erro padrão
     *
     * @param  Throwable $e
     * @param  string    $acao
     * @param  string|array    $data
     *
     * @return array
     */
    protected function defaultErrorReturn(
        Throwable $e,
        $data = null,
        $chave = null,
        $logLevel = 'ERROR'
    ): ServiceResponse {
        $explodedClass = explode('\\', get_called_class());
        $className = end($explodedClass);
        $titulo = strtoupper(str_replace('Service', '', $className));

        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
        $function = $trace[count($trace) - 1]['function'];
        $acao = strtoupper(Str::snake($function)) . '_ERROR';

        $log = activity()->performedOn($className)
            ->withProperties($data)
            ->log($titulo, $acao);

        return new ServiceResponse(
            false,
            "Ocorreu um erro ID" . $log->id,
            $data,
            $log->id
        );
    }
}
