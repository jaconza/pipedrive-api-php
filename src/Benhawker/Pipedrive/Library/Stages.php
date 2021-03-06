<?php namespace Benhawker\Pipedrive\Library;

/**
 * Pipedrive Stage Methods
 *
 * Stage is a logical component of a Pipeline, and essentially a bucket that can hold a number 
 * of Deals. In the context of the Pipeline a stage belongs to, it has an order number which 
 * defines the order of stages in that Pipeline.
 */
class Stages 
{
    /**
     * Hold the pipedrive cURL session
     * @var \Benhawker\Pipedrive\Library\Curl Curl Object
     */
    protected $curl;

    /**
     * Initialise the object load master class
     */
    public function __construct(\Benhawker\Pipedrive\Pipedrive $master)
    {
        //associate curl class
        $this->curl = $master->curl();
    }

    /**
     * Returns all stages on the system.
     *
     * @param int $pipeline
     * @return array stages
     */
    public function getAll($pipeline = null) {
        $data = array();
        if (!empty($pipeline)) {
            $data['pipeline_id'] = $pipeline;
        }

        return $this->curl->get("stages", $data);
    }

    /**
     * Lists deals associated with a stage.
     *
     * @param  array $data (id, start, limit, everyone)
     * @return array deals
     */
    public function deals($data) {
        //if there is no id set throw error as it is a required field
        if (!isset($data['id'])) {
            throw new PipedriveMissingFieldError('You must include the "id" of the stage when getting deals');
        }
        $stageId = intval($data['id']);
        unset($data['id']);

        return $this->curl->get("stages/" . $stageId . "/deals", $data);
    }
}
