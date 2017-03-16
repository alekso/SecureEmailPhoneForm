<?php
namespace app\Contact\Repository;

class ContactRepository {
    /**
     * @var \PDO
     */
    private $connection;

    /**
     * @var string
     * Contacts database table
     */
    private $db_table="tbl_contacts";

    /**
     * ContactRepository constructor.
     * @param \PDO $connection
     */
    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param $email
     * @param $phone
     * @return \PDOStatement
     */
    public function save($email, $phone){
        try
        {
            $checkRecord=$this->findByEmail($email);
            if ($checkRecord)
            {
                $this->delete($checkRecord);
            }

            $createQuery="INSERT INTO ".$this->db_table."(email, phone) VALUES(:email, :phone)";
            $statement = $this->connection->prepare($createQuery);

            $statement->execute(array(":email"=>$email, ":phone"=>$phone));

            return $statement;
        }
        catch (\PDOException $ex)
        {
            error_log("A database insert error occurred".$ex->getMessage(), 0);
            exit();
        }
    }

    /**
     * @param string $email
     * @return int | false
     */
    public function findByEmail($email){
        try {
            $statement = $this->connection->prepare("SELECT id FROM ".$this->db_table." WHERE email = :email");
            $statement->execute(array(':email' => $email));

            if ($statement)
            {
                $row=$statement->fetch();
                $result=$row["id"];

                return $result;
            }

            return false;
        }
        catch (\PDOException $ex)
        {
            error_log("Select error occurred".$ex->getMessage(), 0);
            exit();
        }
    }

    /**
     * @param int $id
     * Remove record from database
     * @return void
     */
    public function delete($id)
    {
        try
        {
            $statement = "DELETE FROM ".$this->db_table." WHERE id=".$id;
            // use exec() because no results are returned
            $this->connection->exec($statement);
        }
        catch(\PDOException $ex)
        {
            error_log("Delete error occurred".$ex->getMessage(), 0);
            exit();
        }
    }

    /**
     * @param string $email - hashed email string
     * @return \PDOStatement
     */
    public function getRecordByEmail($email)
    {
        try
        {
            $createQuery="SELECT phone FROM ".$this->db_table." WHERE email=:email";
            $statement = $this->connection->prepare($createQuery);
            $statement->execute(array(":email"=>$email));

            return $statement->fetch();

        }
        catch (\PDOException $ex)
        {
            error_log("Select error occurred".$ex->getMessage(), 0);
            exit();
        }
    }
}
