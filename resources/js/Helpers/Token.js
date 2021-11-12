class Token {
  isValid(token){
    const payload = this.payload(token);
    if(payload){
      return payload.iss == 'http://127.0.0.1:8000/api/auth/login' || 'http://127.0.0.1:8000/api/auth/register' ? true : false;
    }
    return false;
  }
  // Take tke payload from JWT
  payload(token){
    if(token){
      const payload = token.split('.')[1];
      return this.decode(payload);
    }
  }
  // Decode the payload access token 
  decode(payload){
    if(this.isBase64){
      return JSON.parse(atob(payload));
    }
    return false;
  }
  // Check iss on it
  isBase64(str){
    try {
      return btoa(atob(str)).replace(/=/g, "") == str;
    } catch (error) {
      return false;
    }
  }
}

export default Token = new Token();