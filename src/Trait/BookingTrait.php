<?php

namespace App\Trait;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

trait BookingTrait
{
    protected function hasVaildParams(array $params): array
    {
        if (count($params)) {
            if (empty($params['user_hash']) || empty($params['reserve_spot'])) {
                $this->throwError();
            }
            $this->isValidEmail($params['user_hash']);
            $validatedParams = [];
            $validatedParams['user_hash'] = $params['user_hash'];
            $validatedParams['reserve_spot'] = $params['reserve_spot'];
            return $validatedParams;
        }
        $this->throwError();
    }

    protected function hasVaildParamsForFetch(array $params)
    {
        if (count($params)) {
            if (empty($params['user_hash'])) {
                $this->throwError('invalidemail');
            }
            $this->isValidEmail($params['user_hash']);
            return $params['user_hash'];
        }
        $this->throwError('invalidemail');
    }


    private function isValidEmail($email)
    {
        if (!(filter_var($email, FILTER_VALIDATE_EMAIL)
            && preg_match('/@.+\./', $email))) {
            $this->throwError('inValidEmail');
        }
    }

    private function throwError($type = null)
    {
        throw new NotFoundHttpException($this->errorMessage($type));
    }

    private function errorMessage($type = null)
    {
        $type = strtolower($type);
        switch ($type) {
            case 'invalidemail':
                return 'Expecting Vaild email id in user_hash';
            default:
                return "Expecting mandatory parameters like user_hash, reserve_spot";
        }
    }
}
