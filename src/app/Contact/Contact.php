<?php


namespace app\Contact;


class Contact {
    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $phone;

    /**
     * @var string
     * Contacts database table
     */
    private $db_table="tbl_contacts";

    /**
     * @var \PDO
     */
    private $connection;

    /**
     * Contact constructor.
     * @param string $email
     * @param string $phone
     */
    public function __construct($email, $phone)
    {
        $this->email = $email;
        $this->phone = $phone;
    }
    /**
     * @param array $fields associated keys array [":databaseField"=>value]
     * @return \PDOStatement
     */
    protected function save(array $fields)
    {
        try
        {
        $values=join(",", array_keys($fields));
        $fieldNames=str_replace(":", "", $values);

        $createQuery="INSERT INTO ".$this->db_table."(".$fieldNames.") VALUES(".$values.")";
        $statement = $this->connection->prepare($createQuery);

        $statement->execute($fields);

        return $statement;
        }
        catch (\PDOException $ex)
        {
            error_log("A database insert error occurred".$ex->getMessage(), 0);
            exit();
        }
    }

    protected function find(array $condition)
    {
        return $result;
    }

    protected function delete()
    {

    }
}