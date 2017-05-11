<?php 



// get all todos
$app->get('/todos', function ($request, $response) {
        $sth = $this->db->prepare("SELECT * FROM todos ORDER BY id");
        $sth->execute();
        $todos = $sth->fetchAll();
        return $this->response->withJson($todos);
    });

  // Add a new todo
$app->post('/todos', function ($request, $response) {
        $input = $request->getParsedBody();
        $sql = "INSERT INTO todos (title) VALUES (:title)";
         $sth = $this->db->prepare($sql);
        $sth->bindParam("title", $input['title']);
        $sth->execute();
        $input['id'] = $this->db->lastInsertId();
        return $this->response->withJson($input);
    });


// Search for todo with given search teram in their title
$app->get('/todos/search/[{query}]', function ($request, $response, $args) {
        $sth = $this->db->prepare("SELECT * FROM todos WHERE UPPER(title) LIKE :query ORDER BY id");
        $query = "%".$args['query']."%";
        $sth->bindParam("query", $query);
        $sth->execute();
        $todos = $sth->fetchAll();
        return $this->response->withJson($todos);
    });

// Retrieve todo with id
$app->get('/todos/[{id}]', function ($request, $response,$args) {
      $sth = $this->db->prepare("SELECT * FROM todos WHERE id=:id");
      $sth->bindParam("id", $args['id']);
      $sth->execute();
      $todos = $sth->fetchObject();
      return $this->response->withJson($todos);

});

   // DELETE a todo with given id
    $app->delete('/todos/[{id}]', function ($request, $response, $args) {
        $sth = $this->db->prepare("DELETE FROM todos WHERE id=:id");
        $sth->bindParam("id", $args['id']);
        $sth->execute();
        $todos = $sth->fetchAll();
        return $this->response->withJson($todos);
    });

    // Update todo with given id
    $app->put('/todos/[{id}]', function ($request, $response, $args) {
        $input = $request->getParsedBody();
        $sql = "UPDATE todos SET title=:title WHERE id=:id";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("id", $args['id']);
        $sth->bindParam("task", $input['task']);
        $sth->execute();
        $input['id'] = $args['id'];
        return $this->response->withJson($input);
    });



