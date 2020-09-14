<?php
    /**
     * Google Cloud Module for OliveWeb
     * 
     * @author Luke Bullard
     */
    
    //make sure we are included securely
    if (!defined("INPROCESS")) { header("HTTP/1.0 403 Forbidden"); exit(0); }

    use Google\Cloud\BigQuery\BigQueryClient;

    /**
     * The Google Cloud OliveWeb Module
     */
    class MOD_googlecloud
    {
        private $m_clients;

        public function __construct()
        {
            require_once(__DIR__ . "/../../vendor/autoload.php");
            $this->m_clients = array();
        }

        /**
         * Retrieves the BigQueryClient object. Creates the object if it has not been created already.
         * 
         * @param String $a_projectID The project ID from the Google Developer's Console, or an empty string to omit.
         * @param String $a_keyFilePath The path to the json key file containing the service account credentials,
         *                  or an empty string to use the environment variable value.
         * @return BigQueryClient
         */
        public function getBigQueryClient($a_projectID = "", $a_keyFilePath = __DIR__ . "/keyfile.json")
        {
            $hash = "bigquery_" . md5(strtolower($a_projectID . $a_keyFilePath));

            if (isset($this->m_clients[$hash]))
            {
                return $this->m_clients[$hash];
            }

            $bigQueryArgs = array();

            //if the keyfile path was specified, process it
            if ($a_keyFilePath != "")
            {
                $bigQueryArgs['keyFilePath'] = $a_keyFilePath;
            }

            //if the projectID was set, process it
            if ($a_projectID != "")
            {
                $bigQueryArgs['projectId'] = $a_projectID;
            }

            $this->m_clients[$hash] = new BigQueryClient($bigQueryArgs);

            return $this->m_clients[$hash];
        }
    }
?>