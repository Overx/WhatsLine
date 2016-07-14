<?php

namespace LineXTI\Whatsapp\Services;

use App\Models\User;


class GoogleContactsService
{
    private $config;
    private $curl;
    private $auth;
    private $headers;

    public function __construct()
    {
        $this->curl = curl_init();
    }

    public function getContacts(array $config, $user)
    {
        if (!array_key_exists($user, $config)) {
            throw new Exception('No Credentials for the user requested are available.');
        } else {
            $this->config = $config;
            $contacts = $this->getGoogleContacts($user);
        }
        if (is_array($contacts)) {
            return $contacts;
        }

        return false;
    }

    private function getGoogleContacts($user)
    {
        if (!isset($this->config[$user]['email'])) {
            throw new Exception("Email address for $user was not supplied or set.");
        }

        try {
            $auth = $this->getAuthString($user);
            $this->setHeaders($auth);
            $groupid = $this->getGoogleGroupId('System Group: My Contacts');
            $contacts = $this->retreiveContacts($groupid);
        } catch (Exception $e) {
            throw $e;
        }

        return $contacts;
    }

    private function getAuthString($user)
    {
        // Construct an HTTP POST request
        $clientlogin_url = 'https://www.google.com/accounts/ClientLogin';
        $clientlogin_post = [
            'accountType' => 'HOSTED_OR_GOOGLE',
            'Email'       => $this->config[$user]['email'],
            'Passwd'      => $this->config[$user]['emailPassword'],
            'service'     => 'cp',
            'source'      => 'whatsapp',
        ];

        // Set some options (some for SHTTP)
        curl_setopt($this->curl, CURLOPT_URL, $clientlogin_url);
        curl_setopt($this->curl, CURLOPT_POST, true);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $clientlogin_post);
        curl_setopt($this->curl, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);

        // Execute
        $authresponse = curl_exec($this->curl);

        dd($authresponse);

        // Get the Auth string and save it
        $matches = null;
        $res = preg_match('/Auth=([a-z0-9_-]+)/i', $authresponse, $matches);
        if ($res == 1) {
            $this->auth = $matches[1];

            return $matches[1];
        }
        throw new \Exception('Could not get Authentication code from google');
    }

    private function setHeaders($auth)
    {
        $this->headers = [
            'Authorization: GoogleLogin auth='.$auth,
            'GData-Version: 2.0',
        ];
    }

    private function getHeaders()
    {
        return $this->headers;
    }

    private function getGoogleGroupId($groupname)
    {
        // Connect to Google and get a list of all contact groups.
        curl_setopt($this->curl, CURLOPT_URL, 'https://www.google.com/m8/feeds/groups/default/full');
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->getHeaders());
        curl_setopt($this->curl, CURLOPT_POST, false);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);

        $groupresponse = curl_exec($this->curl);

        //Load XML response
        $atom = simplexml_load_string($groupresponse);

        //Find the group id for the main contact group.
        foreach ($atom->entry as $entry) {
            if (stristr($entry->title, $groupname) !== false) {
                $contactgroup = $entry->id;
            }
        }

        if (isset($contactgroup)) {
            return $contactgroup;
        } else {
            return false;
        }
    }

    private function retreiveContacts($groupid)
    {
        curl_setopt($this->curl, CURLOPT_URL, "https://www.google.com/m8/feeds/contacts/default/full?max-results=2000&group=$groupid");
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->getHeaders());
        curl_setopt($this->curl, CURLOPT_POST, false);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);

        $contactsresponse = curl_exec($this->curl);
        curl_close($this->curl);

        //Load XML response
        $contactsxml = simplexml_load_string($contactsresponse);
        $data = [];
        foreach ($contactsxml->entry as $entry) {
            $name = $entry->title;
            $gd = $entry->children('http://schemas.google.com/g/2005');
            foreach ($gd->phoneNumber as $p) {
                if ($p->attributes()->rel == 'http://schemas.google.com/g/2005#mobile') {
                    $n = trim(preg_replace("/[\D+]*/", '', $p));
                    if (substr((string) $n, 0, 1) !== '0' && strlen($n) > 10) {
                        $data[] = ['name' => "$name ($n)", 'id' => $n];
                    }
                }
            }
        }
        usort($data, [$this, 'sortByName']);

        return $data;
    }

    public function sortByName($a, $b)
    {
        return strcasecmp($a['name'], $b['name']);
    }
}