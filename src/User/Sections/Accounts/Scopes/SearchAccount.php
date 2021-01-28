<?php

namespace AwemaPL\BaselinkerClient\User\Sections\Accounts\Scopes;
use AwemaPL\Repository\Scopes\ScopeAbstract;

class SearchAccount extends ScopeAbstract
{
    /**
     * Scope
     *
     * @param $builder
     * @param $value
     * @param $scope
     * @return mixed
     */
    public function scope($builder, $value, $scope)
    {
        if (!$value){
            return $builder;
        }

        return $builder->where('email', 'like', '%'.$value.'%');
    }
}
