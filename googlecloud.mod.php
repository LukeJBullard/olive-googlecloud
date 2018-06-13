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
            require_once("vendor/autoload.php");
            $this->m_clients = array();
        }

        /**
         * Retrieves the BigQueryClient object. Creates the object if it has not been created already.
         * 
         * @param String $a_keyFilePath The path to the json key file containing the service account credentials, or an empty string to use the environment variable value.
         * @return BigQueryClient
         */
        public function getBigQueryClient($a_keyFilePath = "keyfile.json")
        {
            if (isset($this->m_clients['bigquery']))
            {
                return $this->m_clients['bigquery'];
            }

            if ($a_keyFilePath != "")
            {
                $this->m_clients['bigquery'] = new BigQueryClient([
                    'keyFilePath' => $a_keyFilePath
                ]);
            } else {
                $this->m_clients['bigquery'] = new BigQueryClient();
            }

            return $this->m_clients['bigquery'];
        }
    }
?>