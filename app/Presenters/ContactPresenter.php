<?php

namespace Jas\Presenters;

use Jas\Transformers\ContactTransformer;
use League\Fractal\TransformerAbstract;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ContactPresenter.
 *
 * @package namespace Jas\Presenters;
 */
class ContactPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return TransformerAbstract
     */
    public function getTransformer()
    {
        return new ContactTransformer();
    }
}
