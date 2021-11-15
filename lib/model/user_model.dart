class UserModel {
  String customerID;
  String username;
  String name;
  String telephone;
  String password;
  String status;

  UserModel(
      {this.customerID,
      this.username,
      this.name,
      this.telephone,
      this.password,
      this.status});

  UserModel.fromJson(Map<String, dynamic> json) {
    customerID = json['customerID'];
    username = json['username'];
    name = json['name'];
    telephone = json['telephone'];
    password = json['password'];
    status = json['status'];
  }

  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = new Map<String, dynamic>();
    data['customerID'] = this.customerID;
    data['username'] = this.username;
    data['name'] = this.name;
    data['telephone'] = this.telephone;
    data['password'] = this.password;
    data['status'] = this.status;
    return data;
  }
}
