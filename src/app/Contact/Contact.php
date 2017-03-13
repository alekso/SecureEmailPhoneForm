<?php
namespace app\Contact;
use app\encryption\IEncryption;

/**
 * Contact class file.
 *
 */
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
     * @var IEncryption
     */
    private $encryptor;
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
     * Contact constructor.
     * @param string $email
     * @param IEncryption $encryptor
     * @param \PDO $connection
     */
    public function __construct($email, IEncryption $encryptor, \PDO $connection)
    {
        $this->email = $email;
        $this->encryptor = $encryptor;
        $this->connection=$connection;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string | boolean
     */
    public function getPhone()
    {
        if (isset($this->phone)){
            return $this->phone;
        }
        $_email=$this->getEmailHash();
        $record=$this->getRecordByEmail($_email);
        if ($record) return $this->decrypt($record["phone"]);
        return false;
    }

    /**
     * @return string
     */
    public function getEmailHash(){
        return $this->encryptor->hash($this->email);
    }

    /**
     * @return int
     */
    public function encrypt(){
        if (!empty($this->phone)&&!empty($this->phone)) {
            return $this->encryptor->encrypt($this->phone, $this->email);
        }
        return null;
    }

    /**
     * @param $phone_hash
     * @return mixed
     */
    protected function decrypt($phone_hash){
        return $this->encryptor->decrypt($phone_hash, $this->email);
    }

    /**
     *@return null
     */
    public function createSecure()
    {
        $_email=$this->getEmailHash();
        $_phone=$this->encrypt();
        $this->createRecord($_email, $_phone);
    }

    /**
     * @param $email
     * @param $phone
     * @return \PDOStatement
     */
    private function createRecord($email, $phone){
        try{
            $checkRecord=$this->isRecord($email);
            if ($checkRecord) {
                $this->deleteById($checkRecord);
            }
            $createQuery="INSERT INTO ".$this->db_table."(email,phone) VALUES(:email, :phone)";
            $statement = $this->connection->prepare($createQuery);
            $statement->execute(array(":email"=>$email, ":phone"=>$phone));
            return $statement;
        } catch (\PDOException $ex){
            error_log("A database insert error occurred".$ex->getMessage(), 0);
            exit();
        }
    }

    /**
     * @param string $value
     * @return int | false
     */
    private function isRecord($value){
        try {
            $statement = $this->connection->prepare("SELECT id FROM ".$this->db_table." WHERE email = :email");
            $statement->execute(array(':email' => $value));
            if ($statement) {
                $row=$statement->fetch();
                $result=$row["id"];
                return $result;
            }
            return false;
        } catch (\PDOException $ex){
            error_log("Select error occurred".$ex->getMessage(), 0);
            exit();
        }
    }

    /**
     * @param int $id
     * Remove record from database
     * @return null
     */
    private function deleteById($id)
    {
        try {
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
    private function getRecordByEmail($email){
        try{
            $createQuery="SELECT phone FROM ".$this->db_table." WHERE email=:email";
            $statement = $this->connection->prepare($createQuery);
            $statement->execute(array(":email"=>$email));
            return $statement->fetch();

        } catch (\PDOException $ex){
            error_log("Select error occurred".$ex->getMessage(), 0);
            exit();
        }
    }

    /**
     * @return mixed
     */
    public function retrievePhone()
    {
        $phone=$this->getPhone();
        if ($phone) {
            $subject="Your phone number";
            $message="Hi there,\n This email was sent from ".$_SERVER['HTTP_HOST'].". Your phone number is ".$phone;
            $this->sendEmail($this->getEmail(), $subject, $message);
            return true;
        }
        echo "Phone number for this email not found in the database."."<br />";
        exit();
    }

    /**
     * @param $to
     * @param $subject
     * @param $message
     */
    protected function sendEmail($to, $subject, $message)
    {
        $result=mail($to, $subject,$message);
        if(!$result){
            error_log("Cant send email please check your sendmail_path php.ini configuration or system log", 0);
        }
    }
}