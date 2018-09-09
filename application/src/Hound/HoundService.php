<?php namespace Application\Hound;

use Concrete\Core\Support\Facade\Application;

class HoundService
{
    protected $config;

    public function __construct()
    {
        $app = Application::getFacadeApplication();
        $this->config = $app->make('config');
    }

    public function getHounds()
    {
        $url = 'https://api.rescuegroups.org/http/v2.json';
        $json = json_encode($this->getRequestData());
        $requestResult = $this->makeApiRequest($url, $json);
        if (!$requestResult['error'])
        {
            $json = json_decode($requestResult['result'], true);
            return $json['data'];
        }
        return false;
    }

    public function makeApiRequest($url, $json)
    {
        // create a new cURL resource
        $ch = curl_init();
        // set options, url, etc.
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_POST, 1);
        //curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // grab URL and pass it to the browser
        $result = curl_exec($ch);

        return  ['error' => curl_errno($ch), 'result' => $result];
    }

    private function getRequestData()
    {
        $data = [
            'apikey' => 'SUNOXcTi',
            'objectType' => 'animals',
            'objectAction' => 'publicSearch',
            'search' => [
                'resultSort' => 'animalName',
                'fields' => [
                    'animalID',
                    'animalName',
                    'animalBirthdate',
                    'animalSpecies',
                    'animalThumbnailUrl',
                    'animalOKWithCats',
                    'animalOKWithDogs',
                    'animalSummary',
                    'animalDescriptionPlain',
                    'animalPictures',
                    'animalAdoptionPending'
                ],
                'filters' => [
                    [
                        'fieldName' => 'animalStatus',
                        'operation' => 'equals',
                        'criteria' => 'Available'
                    ],
                    [
                        'fieldName' => 'animalOrgID',
                        'operation' => 'equals',
                        'criteria' => 5903
                    ]
                ]
            ]
        ];

        $apiKey = $this->config->get('keys.rescue_groups_api_key');
        $groupID = $this->config->get('keys.rescue_groups_id');

        //$data['apikey'] = $apiKey;
        //array_push($data['search']['filters'], ['fieldName' => 'animalOrgID', 'operation' => 'equals', 'criteria' => $groupID]);
        return $data;
    }
}
