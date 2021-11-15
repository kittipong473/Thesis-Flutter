import 'package:flutter/material.dart';
import 'package:myproject/screens/main_page.dart';
import 'package:myproject/screens/register.dart';
import 'package:myproject/screens/signin.dart';
import 'package:myproject/utility/my_style.dart';
import 'package:myproject/utility/normal_dialog.dart';
import 'package:shared_preferences/shared_preferences.dart';

class Home extends StatefulWidget {
  @override
  _HomeState createState() => _HomeState();
}

class _HomeState extends State<Home> {
  @override
  void initState() {
    super.initState();
    checkPreference();
  }

  Future<Null> checkPreference() async {
    try {
      SharedPreferences preferences = await SharedPreferences.getInstance();
      String name = preferences.getString('name');
      if (name != null && name.isNotEmpty) {
        routeToService();
      } else {
        MyStyle().titleCenter('You are not login yet');
      }
    } catch (e) {}
  }

  void routeToService() {
    MaterialPageRoute route = MaterialPageRoute(
      builder: (context) => MainPage(),
    );
    Navigator.pushAndRemoveUntil(context, route, (route) => false);
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('ICar Service Application'),
      ),
      body: Container(
        decoration: BoxDecoration(
          gradient: RadialGradient(
              colors: <Color>[Colors.white, MyStyle().primaryColor],
              center: Alignment(0, -0.3),
              radius: 1.0),
        ),
        child: Center(
          child: SingleChildScrollView(
            child: Column(
              mainAxisSize: MainAxisSize.min,
              children: <Widget>[
                MyStyle().showLogo(),
                MyStyle().mySizedBox(),
                MyStyle().mySizedBox(),
                MyStyle().mySizedBox(),
                MyStyle().showTitle('Welcome to ICar Service'),
                MyStyle().mySizedBox(),
                MyStyle().showTitle2('Application for service customer car'),
                MyStyle().mySizedBox(),
                MyStyle().mySizedBox(),
                MyStyle().mySizedBox(),
                loginButton(),
                MyStyle().mySizedBox(),
                registerButton(),
                MyStyle().mySizedBox(),
              ],
            ),
          ),
        ),
      ),
    );
  }

  Widget loginButton() => Container(
        width: 100.0,
        child: RaisedButton(
          color: MyStyle().darkColor,
          onPressed: () {
            Navigator.pop(context);
            MaterialPageRoute route =
                MaterialPageRoute(builder: (value) => SignIn());
            Navigator.push(context, route);
          },
          child: Text('Login', style: TextStyle(color: Colors.white)),
        ),
      );

  Widget registerButton() => Container(
        width: 100.0,
        child: RaisedButton(
          color: MyStyle().darkColor,
          onPressed: () {
            Navigator.pop(context);
            MaterialPageRoute route =
                MaterialPageRoute(builder: (value) => Register());
            Navigator.push(context, route);
          },
          child: Text('Register', style: TextStyle(color: Colors.white)),
        ),
      );

}
