<?php

namespace Jas\Presenters;

use Jas\Transformers\PersonTransformer;
use League\Fractal\TransformerAbstract;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class PersonPresenter.
 *
 * @package namespace Jas\Presenters;
 */
class PersonPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return TransformerAbstract
     */
    public function getTransformer()
    {
        return new PersonTransformer();
    }
}
