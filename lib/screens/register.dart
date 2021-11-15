import 'package:dio/dio.dart';
import 'package:flutter/material.dart';
import 'package:myproject/screens/home.dart';
import 'package:myproject/screens/signin.dart';
import 'package:myproject/utility/my_style.dart';
import 'package:myproject/utility/my_constant.dart';
import 'package:myproject/utility/normal_dialog.dart';

class Register extends StatefulWidget {
  @override
  _RegisterState createState() => _RegisterState();
}

class _RegisterState extends State<Register> {
  String user, password, name, tel, age, ins;

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text("Register"),
      ),
      drawer: showDrawer(),
      body: ListView(padding: EdgeInsets.all(30.0), children: <Widget>[
        myLogo(),
        MyStyle().mySizedBox(),
        showAppName(),
        MyStyle().mySizedBox(),
        userForm(),
        MyStyle().mySizedBox(),
        passwordForm(),
        MyStyle().mySizedBox(),
        nameForm(),
        MyStyle().mySizedBox(),
        telephoneForm(),
        MyStyle().mySizedBox(),
        registerButton(),
        MyStyle().mySizedBox(),
        MyStyle().mySizedBox(),
        MyStyle().mySizedBox(),
        backButton(),
      ]),
    );
  }

  Widget userForm() => Row(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Container(
            width: 250.0,
            child: TextField(
              onChanged: (value) => user = value.trim(),
              maxLength: 30,
              decoration: InputDecoration(
                prefixIcon: Icon(
                  Icons.account_box,
                  color: MyStyle().darkColor,
                ),
                labelStyle: TextStyle(color: MyStyle().darkColor),
                labelText: 'Username',
                enabledBorder: OutlineInputBorder(
                    borderSide: BorderSide(color: MyStyle().darkColor)),
                focusedBorder: OutlineInputBorder(
                    borderSide: BorderSide(color: MyStyle().primaryColor)),
              ),
            ),
          ),
        ],
      );

  Widget passwordForm() => Row(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Container(
            width: 250.0,
            child: TextField(
              onChanged: (value) => password = value.trim(),
              maxLength: 10,
              obscureText: true,
              decoration: InputDecoration(
                prefixIcon: Icon(
                  Icons.lock,
                  color: MyStyle().darkColor,
                ),
                labelStyle: TextStyle(color: MyStyle().darkColor),
                labelText: 'Password',
                enabledBorder: OutlineInputBorder(
                    borderSide: BorderSide(color: MyStyle().darkColor)),
                focusedBorder: OutlineInputBorder(
                    borderSide: BorderSide(color: MyStyle().primaryColor)),
              ),
            ),
          ),
        ],
      );

  Widget nameForm() => Row(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Container(
            width: 250.0,
            child: TextField(
              onChanged: (value) => name = value.trim(),
              maxLength: 30,
              decoration: InputDecoration(
                prefixIcon: Icon(
                  Icons.face,
                  color: MyStyle().darkColor,
                ),
                labelStyle: TextStyle(color: MyStyle().darkColor),
                labelText: 'Customer Name',
                enabledBorder: OutlineInputBorder(
                    borderSide: BorderSide(color: MyStyle().darkColor)),
                focusedBorder: OutlineInputBorder(
                    borderSide: BorderSide(color: MyStyle().primaryColor)),
              ),
            ),
          ),
        ],
      );

  Widget telephoneForm() => Row(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Container(
            width: 250.0,
            child: TextField(
              onChanged: (value) => tel = value.trim(),
              maxLength: 10,
              keyboardType: TextInputType.phone,
              decoration: InputDecoration(
                prefixIcon: Icon(
                  Icons.local_phone,
                  color: MyStyle().darkColor,
                ),
                labelStyle: TextStyle(color: MyStyle().darkColor),
                labelText: 'Tel. Nuber',
                enabledBorder: OutlineInputBorder(
                    borderSide: BorderSide(color: MyStyle().darkColor)),
                focusedBorder: OutlineInputBorder(
                    borderSide: BorderSide(color: MyStyle().primaryColor)),
              ),
            ),
          ),
        ],
      );

  Widget registerButton() => Container(
        width: 250.0,
        child: RaisedButton(
          color: MyStyle().darkColor,
          onPressed: () {
            if (user == null ||
                user.isEmpty ||
                password == null ||
                password.isEmpty) {
              normalDialog(context, "Please fill Username and Password");
            } else {
              checkUser();
            }
          },
          child: Text('Register', style: TextStyle(color: Colors.white)),
        ),
      );

  Widget backButton() => Container(
        width: 50.0,
        child: RaisedButton(
          color: MyStyle().redColor,
          onPressed: () {
            Navigator.pop(context);
            MaterialPageRoute route =
                MaterialPageRoute(builder: (value) => Home());
            Navigator.push(context, route);
          },
          child: Text('Back', style: TextStyle(color: Colors.white)),
        ),
      );

  Future<Null> checkUser() async {
    String url =
        '${MyConstant().domain}/database/getUserWhereUser.php?isAdd=true&username=$user';
    try {
      Response response = await Dio().get(url);
      if (response.toString() == 'null') {
        checkName();
      } else {
        normalDialog(context, 'Username: $user has already used');
      }
    } catch (e) {}
  }

  Future<Null> checkName() async {
    String url =
        '${MyConstant().domain}/database/getUserWhereName.php?isAdd=true&name=$name';
    try {
      Response response = await Dio().get(url);
      if (response.toString() == 'null') {
        registerThread();
      } else {
        normalDialog(context, 'Name: $name has already used');
      }
    } catch (e) {}
  }

  Future<Null> registerThread() async {
    String url =
        '${MyConstant().domain}/database/addCustomer.php?isAdd=true&username=$user&name=$name&telephone=$tel&password=$password';

    try {
      Response response = await Dio().get(url);

      if (response.toString() == 'true') {
        Navigator.pop(context);
        MaterialPageRoute route = MaterialPageRoute(builder: (value) => Home());
        Navigator.push(context, route);
        normalDialog(context, "Register Successfully");
      } else {
        normalDialog(context, "Register Failed");
      }
    } catch (e) {}
  }

  Row showAppName() {
    return Row(
      mainAxisAlignment: MainAxisAlignment.center,
      children: <Widget>[
        MyStyle().showTitle('ICar Service'),
      ],
    );
  }

  Widget myLogo() => Row(
        mainAxisAlignment: MainAxisAlignment.center,
        children: <Widget>[
          MyStyle().showLogo(),
        ],
      );

  Drawer showDrawer() => Drawer(
        child: ListView(
          children: <Widget>[
            showHeaderDrawer(),
            signInMenu(),
            registerMenu(),
          ],
        ),
      );

  ListTile signInMenu() {
    return ListTile(
      leading: Icon(Icons.person_rounded),
      title: Text("Log-In"),
      onTap: () {
        Navigator.pop(context);
        MaterialPageRoute route =
            MaterialPageRoute(builder: (value) => SignIn());
        Navigator.push(context, route);
      },
    );
  }

  ListTile registerMenu() {
    return ListTile(
      leading: Icon(Icons.person_rounded),
      title: Text("Register"),
      onTap: () {
        Navigator.pop(context);
        MaterialPageRoute route =
            MaterialPageRoute(builder: (value) => Register());
        Navigator.push(context, route);
      },
    );
  }

  UserAccountsDrawerHeader showHeaderDrawer() {
    return UserAccountsDrawerHeader(
        decoration: MyStyle().myBoxDecoration('garage.jpg'),
        currentAccountPicture: MyStyle().showLogo(),
        accountName: Text('Guest'),
        accountEmail: Text("Please Login"));
  }
}
