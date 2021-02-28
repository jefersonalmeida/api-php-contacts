<?php

namespace Jas\Transformers;

use Jas\Models\Contact;
use League\Fractal\TransformerAbstract;

/**
 * Class ContactTransformer.
 *
 * @package namespace Jas\Transformers;
 */
class ContactTransformer extends TransformerAbstract
{
    /**
     * Transform the Person entity.
     *
     * @param Contact $model
     *
     * @return array
     */
    public function transform(Contact $model): array
    {
        return [
            'id' => $model->id,
            'person_id' => $model->person_id,
            'type' => $model->type,
            'value' => $model->value,
        ];
    }
}
