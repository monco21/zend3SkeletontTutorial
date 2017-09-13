<?php

namespace Album\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;


class AlbumTable{


    //we set the protected property $tableGateway to the TableGateway instance passed in the constructor,
    // hinting against the TableGatewayInterface
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway){
        $this->tableGateway= $tableGateway;

    }

    //helper methods
    //retrieving all albums rows from the database
    public function fetchAll(){
        return $this->$this->tableGateway->select();
    }



    //retrieves a single row as an Album object
    public function getAlbum($id){
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id'=>$id]);
        $row = $rowset->current();
        if(! $row){
            throw new RuntimeException(sprintf('Could not find row identifier %d', $id));
        }
        return $row;
    }

    //either creates a new row in the database or updates a row that already exists
    public function saveAlbum(Album $album)
    {
        $data = [
            'artist' => $album->artist,
            'title' => $album->title,
        ];

        $id = (int)$album->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (!$this->getAlbum($id)) {
            throw new RuntimeException(sprintf('Cannot update album with identifier %id; does not exist', $id));

        }

        $this->tableGateway->update($data,['id'=>$id]);

    }
        //removes the row completely
        public function deleteAlbum($id){
            $this->tableGateway->delete([$id => (int) $id]);
        }



}