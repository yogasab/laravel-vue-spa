const { default: User } = require("./User");

class Exception {
  handle(error){
    this.isExpired(error.response.data.error);
  }

  isExpired(error){
    if(error = 'Token is expired'){
      User.loggedOut();
    }
  }
}

export default Exception = new Exception;