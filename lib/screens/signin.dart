import 'dart:convert';

import 'package:dio/dio.dart';
import 'package:flutter/material.dart';
import 'package:myproject/screens/home.dart';
import 'package:myproject/screens/main_page.dart';
import 'package:myproject/model/user_model.dart';
import 'package:myproject/screens/register.dart';
import 'package:myproject/utility/my_constant.dart';
import 'package:myproject/utility/my_style.dart';
import 'package:myproject/utility/normal_dialog.dart';
import 'package:shared_preferences/shared_preferences.dart';

class SignIn extends StatefulWidget {
  @override
  _SignInState createState() => _SignInState();
}

class _SignInState extends State<SignIn> {
  // Field
  String user, password;
  UserModel userModel;

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: Text("Log-In")),
      //drawer: showDrawer(),
      body: Container(
        child: Center(
          child: SingleChildScrollView(
            child: Column(
              mainAxisSize: MainAxisSize.min,
              children: <Widget>[
                MyStyle().showLogo(),
                MyStyle().mySizedBox(),
                MyStyle().showTitle('ICar Service'),
                MyStyle().mySizedBox(),
                userForm(),
                MyStyle().mySizedBox(),
                passwordForm(),
                MyStyle().mySizedBox(),
                loginButton(),
                MyStyle().mySizedBox(),
                MyStyle().mySizedBox(),
                MyStyle().mySizedBox(),
                backButton(),
              ],
            ),
          ),
        ),
      ),
    );
  }

  Widget loginButton() => Container(
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
              checkAuthen();
            }
          },
          child: Text('Login', style: TextStyle(color: Colors.white)),
        ),
      );

  Future<Null> checkAuthen() async {
    String url =
        '${MyConstant().domain}/database/getUserWhereUser.php?isAdd=true&username=$user';
    try {
      Response response = await Dio().get(url);
      var result = json.decode(response.data);
      for (var map in result) {
        userModel = UserModel.fromJson(map);

        if (password == userModel.password) {
          checkStatus();
        } else {
          normalDialog(context, "Username or Password is incorrect");
        }
      }
    } catch (e) {}
  }

  Future<Null> checkStatus() async {
    String url =
        '${MyConstant().domain}/database/checkStatus.php?isAdd=true&username=$user';
    try {
      Response response = await Dio().get(url);
      if (response.toString() == 'null') {
        routeToService(userModel);
      } else {
        normalDialog(context, 'Your account has blocked, contact to admin0@email.com (0956492669)');
      }
    } catch (e) {}
  }

  Future<Null> routeToService(UserModel userModel) async {
    SharedPreferences preferences = await SharedPreferences.getInstance();
    preferences.setString('customerID', userModel.customerID);
    preferences.setString('username', userModel.username);
    preferences.setString('name', userModel.name);
    preferences.setString('telephone', userModel.telephone);

    MaterialPageRoute route = MaterialPageRoute(
      builder: (context) => MainPage(),
    );
    Navigator.pushAndRemoveUntil(context, route, (route) => false);
  }

  Widget userForm() => Container(
        width: 250.0,
        child: TextField(
          onChanged: (value) => user = value.trim(),
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
      );

  Widget passwordForm() => Container(
        width: 250.0,
        child: TextField(
          onChanged: (value) => password = value.trim(),
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
      );

  Widget backButton() => Container(
        width: 150.0,
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
}
