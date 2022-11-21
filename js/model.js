function TodoItem(id, content, is_completed) {
  this.id = id;
  this.content = content;
  this.is_completed = is_completed;
}

function AppModel() {
  this.input = "";
  this.todoCollection = [];

  //add the new item in TODO
  this.addTodo = function(content, is_completed) {
    var self = this;
    $.ajax({
      type: "POST",
      url: "actions/insert.php",
      data: {
        content: content,
        is_completed: is_completed
      },
      success: function(data) {
        var res = JSON.parse(data);
        var log = res.data;
        self.todoCollection.push(
          new TodoItem(log["id"], log["content"], log["is_completed"])
        );
      },
      error: function(data) {
        alert(JSON.stringify(JSON.parse(data)));
      }
    });
  };

  //remove the element from TODO
  this.removeTodo = function(id, i) {
    var self = this;
    $.ajax({
      url: "actions/delete.php?id=" + id,
      success: function(data) {
        self.todoCollection.splice(i, 1);
      }
    });
  };

  //edit the element From TODO
  this.updateTodo = function(id, new_content, i) {
    var self = this;
    $.ajax({
      type: "POST",
      url: "actions/edit.php",
      data: {
        id: id,
        content: new_content
      },
      success: function(data) {
        var res = JSON.parse(data);
        var log = res.error;
        if (log == true) {
          console.log(res.data);
        } else {
          self.todoCollection[i].content = new_content;
        }
      },
      error: function(data) {
        self.errorlog(data);
      }
    });
  };

  //toggle the isCompelete status from TODO
  this.toggle = function(id, i) {
    var self = this;
    $.ajax({
      type: "POST",
      url: "actions/edit.php",
      data: {
        id: id,
        content: null
      },
      success: function(data) {
        var val = self.todoCollection[i].is_completed;
        if (val == 0) {
          self.todoCollection[i].is_completed = 1;
        } else {
          self.todoCollection[i].is_completed = 0;
        }
      }
    });
  };

  //show all the data from TODO
  this.showTodo = function() {
    var self = this;
    $.ajax({
      url: "actions/get.php",
      data: {
        filter: "all"
      },
      success: function(result) {
        var log = JSON.stringify(result.data);
        self.todoCollection = JSON.parse(log);
        console.log(self.todoCollection);
      }
    });
  };

  //show Completed the data from TODO
  this.showCompletedTodo = function() {
    var self = this;
    $.ajax({
      url: "actions/get.php",
      data: {
        filter: "completed"
      },
      success: function(result) {
        var log = JSON.stringify(result.data);
        self.todoCollection = JSON.parse(log);
        console.log(self.todoCollection);
      }
    });
  };

  //show incompleted the data from TODO
  this.showIncompletedTodo = function() {
    var self = this;
    $.ajax({
      url: "actions/get.php",
      data: {
        filter: "incompleted"
      },
      success: function(result) {
        var log = JSON.stringify(result.data);
        self.todoCollection = JSON.parse(log);
        console.log(self.todoCollection);
      }
    });
  };

  //handle ajax error
  this.errorlog = function(data) {
    var errorMsg = data.statusText;
    var errorStatus = data.status;
    console.log(errorMsg + " " + errorStatus);
  };
}
