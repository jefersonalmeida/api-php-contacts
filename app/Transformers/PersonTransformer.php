<?php

namespace Jas\Transformers;

use Jas\Models\Person;
use League\Fractal\TransformerAbstract;

/**
 * Class PersonTransformer.
 *
 * @package namespace Jas\Transformers;
 */
class PersonTransformer extends TransformerAbstract
{
    /**
     * Transform the Person entity.
     *
     * @param Person $model
     *
     * @return array
     */
    public function transform(Person $model): array
    {
        return [
            'id' => $model->id,
            'name' => $model->name,
        ];
    }
}
