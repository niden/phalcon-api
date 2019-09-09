<?php

declare(strict_types=1);

namespace Niden\Models;

use Niden\Constants\Relationships;
use Niden\Mvc\Model\AbstractModel;
use Phalcon\Filter;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness;

/**
 * Class Companies
 *
 * @package Niden\Models
 */
class Companies extends AbstractModel
{
    /**
     * Initialize relationships and model properties
     */
    public function initialize()
    {
        $this->hasMany(
            'id',
            Individuals::class,
            'companyId',
            [
                'alias'    => Relationships::INDIVIDUALS,
                'reusable' => true,
            ]
        );

        $this->hasManyToMany(
            'id',
            CompaniesXProducts::class,
            'companyId',
            'productId',
            Products::class,
            'id',
            [
                'alias'    => Relationships::PRODUCTS,
                'reusable' => true,
            ]
        );

        parent::initialize();
    }

    /**
     * Model filters
     *
     * @return array<string,string>
     */
    public function getModelFilters(): array
    {
        return [
            'id'      => Filter::FILTER_ABSINT,
            'name'    => Filter::FILTER_STRING,
            'address' => Filter::FILTER_STRING,
            'city'    => Filter::FILTER_STRING,
            'phone'   => Filter::FILTER_STRING,
        ];
    }

    /**
     * Returns the source table from the database
     *
     * @return string
     */
    public function getSource(): string
    {
        return 'co_companies';
    }

    /**
     * Validates the company name
     *
     * @return bool
     */
    public function validation()
    {
        $validator = new Validation();
        $validator->add(
            'name',
            new Uniqueness(
                [
                    'message' => 'The company name already exists in the database',
                ]
            )
        );

        return $this->validate($validator);
    }
}
