<?php

declare(strict_types=1);

namespace Niden\Api\Controllers;

use function explode;
use function in_array;
use Niden\Exception\ModelException;
use Niden\Http\Request;
use Niden\Http\Response;
use Niden\Models\Users;
use Niden\Traits\FractalTrait;
use Niden\Traits\QueryTrait;
use Niden\Traits\ResponseTrait;
use Niden\Traits\TokenTrait;
use Niden\Transformers\BaseTransformer;
use Phalcon\Filter;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Model\ResultsetInterface;
use function strtolower;
use function trim;

/**
 * Class BaseController
 *
 * @package Niden\Api\Controllers
 *
 * @property Micro    $application
 * @property Response $response
 */
class BaseController extends Controller
{
    use FractalTrait;
    use QueryTrait;
    use ResponseTrait;

    /** @var string */
    protected $model         = '';
    /** @var array */
    protected $relationships = [];
    /** @var string */
    protected $resource      = '';
    /** @var string */
    protected $transformer   = '';
    /** @var string */
    protected $orderBy       = 'name';

    /**
     * Get the company/companies
     *
     * @param int    $id
     * @param string $relationships
     *
     * @return array
     */
    public function callAction($id = 0, $relationships = '')
    {
        $parameters = $this->checkIdParameter($id);
        $parameter  = $this->filter->sanitize($relationships, [Filter::FILTER_STRING, Filter::FILTER_TRIM]);
        $results    = $this->getRecords($this->model, $parameters, $this->orderBy);
        $related    = [];

        if (count($parameters) > 0 && 0 === count($results)) {
            return $this->send404();
        } else {
            if (true !== empty($parameter)) {
                $allRelationships = explode(',', $relationships);
                foreach ($allRelationships as $relationship) {
                    if (true !== in_array($relationship, $this->relationships)) {
                        return $this->send404();
                    }

                    $results[] = strtolower($relationship);
                }
            }
        }

        return $this->format($results, $this->transformer, $this->resource, $related);
    }

    /**
     * Checks the passed id parameter and returns the relevant array back
     *
     * @param int    $recordId
     *
     * @return array
     */
    private function checkIdParameter($recordId = 0): array
    {
        $parameters = [];

        /** @var int $localId */
        $localId = $this->filter->sanitize($recordId, Filter::FILTER_ABSINT);

        if ($localId > 0) {
            $parameters['id'] = $localId;
        }

        return $parameters;
    }

    /**
     * Sends a 404 back
     */
    private function send404()
    {
        $this->response->setPayloadError('Not Found')->setStatusCode(404);
    }
}
