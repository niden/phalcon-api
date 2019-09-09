<?php

namespace Niden\Tests\integration\library\Transformers;

use IntegrationTester;
use Niden\Validation\CompaniesValidator;

class CompaniesValidatorCest
{
    /**
     * @param IntegrationTester $I
     *
     * @throws \Niden\Exception\ModelException
     */
    public function checkTransformer(IntegrationTester $I)
    {
        $validation = new CompaniesValidator();
        $_POST      = [
            'name'    => '',
            'address' => '123 Phalcon way',
            'city'    => 'World',
            'phone'   => '555-999-4444',
        ];
        $messages   = $validation->validate($_POST);
        $I->assertEquals(1, count($messages));
        $I->assertEquals('The company name is required', $messages[0]->getMessage());
    }
}
