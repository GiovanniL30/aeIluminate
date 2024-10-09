export default class Account {
  constructor({
    userId,
    name,
    userName,
    email,
    userType,
    firstName,
    middleName,
    lastName,
    roleType,
    password,
  }) {
    (this.userId = userId),
      (this.name = name),
      (this.userName = userName),
      (this.email = email),
      (this.userType = userType),
      (this.firstName = firstName),
      (this.middleName = middleName),
      (this.lastName = lastName),
      (this.roleType = roleType),
      (this.password = password);
  }

  setPassword(i) {
    this.password = i;
  }

  setFirstName(i) {
    this.firstName = i;
  }

  setMiddleName(i) {
    this.middleName = i;
  }

  setLastName(i) {
    this.lastName = i;
  }

  setUserName(i) {
    this.userName;
  }

  setRole(i) {
    this.roleType = i;
  }

  setEmail(i) {
    this.email = i;
  }
}
