import Axios from "axios";
import AppStorage from "./AppStorage";
import Token from "./Token";

class User {
  login(data){
    Axios.post('/api/auth/login', data)
    .then(res => {
      // Response after login
      this.responseAfterLogin(res);
      // Token.payload(res.data.access_token);
    })
    .catch(err => console.log(err.response.data))
  }
  // response after login
  responseAfterLogin(res){
    // take the token and user 
    const token = res.data.access_token;
    const user = res.data.user;
    // check from Token class isValid
    if(Token.isValid(token)){
      // Store it to LocalStorage
      AppStorage.store(token, user);
    }
  }

  hasToken(){
    const storedToken = AppStorage.getToken();
    if(storedToken){
      return Token.isValid(storedToken) ? true: false;
    }
    return false;
  }

  loggedIn(){
    return this.hasToken();
  }

  loggedOut(){
    AppStorage.clear();
  }

  name(){
    if(this.loggedIn()){
      return AppStorage.getUser();
    }
  }

  id(){
    if(this.loggedIn()){
      const payload = Token.payload(AppStorage.getToken());
      return payload.sub;
    }
    return false;
  }
}

export default User = new User();