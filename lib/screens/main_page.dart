import 'dart:io';

import 'package:flutter/material.dart';
import 'package:myproject/model/user_model.dart';
import 'package:myproject/widget/check_location.dart';
import 'package:myproject/widget/add_inform.dart';
import 'package:myproject/utility/my_style.dart';
import 'package:myproject/utility/signout_process.dart';
import 'package:myproject/widget/data_list.dart';
import 'package:myproject/widget/information_list.dart';
import 'package:shared_preferences/shared_preferences.dart';

class MainPage extends StatefulWidget {
  @override
  _MainPageState createState() => _MainPageState();
}

class _MainPageState extends State<MainPage> {
  String nameUser, userName;
  Widget currentWidget = DataList();

  @override
  void initState() {
    super.initState();
    findUser();
  }

  Future<Null> findUser() async {
    SharedPreferences preferences = await SharedPreferences.getInstance();
    setState(() {
      nameUser = preferences.getString('name');
      userName = preferences.getString('username');
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title:
            Text(nameUser == null ? "Welcome customer" : 'Welcome: $nameUser'),
        actions: <Widget>[
          IconButton(
              icon: Icon(Icons.exit_to_app),
              onPressed: () => confirmSignout())
        ],
      ),
      drawer: showDrawer(),
      body: currentWidget,
    );
  }

  Drawer showDrawer() => Drawer(
        child: ListView(
          children: <Widget>[
            showHeaderDrawer(),
            dataMenu(),
            informationMenu(),
            checkMenu(),
            logoutMenu(),
          ],
        ),
      );

  ListTile informationMenu() => ListTile(
        leading: Icon(Icons.file_copy),
        title: Text('ข้อมูล User'),
        subtitle: Text('ตรวจสอบ ข้อมูลของผู้ใช้งาน'),
        onTap: () {
          setState(() {
            currentWidget = InformationList();
          });
          Navigator.pop(context);
        },
      );

  ListTile dataMenu() => ListTile(
        leading: Icon(Icons.add_alert_sharp),
        title: Text('เหตุการณ์'),
        subtitle: Text('แจ้ง/ตรวจสอบ/ลบ เหตุการณ์ของผู้ใช้งาน'),
        onTap: () {
          setState(() {
            currentWidget = DataList();
          });
          Navigator.pop(context);
        },
      );

  ListTile checkMenu() => ListTile(
        leading: Icon(Icons.add_alert_sharp),
        title: Text('ศูนย์ซ่อม'),
        subtitle: Text('ตรวจสอบศูนย์ซ่อมรถ ใกล้ตำแหน่งของคุณ'),
        onTap: () {
          setState(() {
            currentWidget = CheckLocation();
          });
          Navigator.pop(context);
        },
      );

  ListTile logoutMenu() => ListTile(
        leading: Icon(Icons.exit_to_app),
        title: Text('Sign Out'),
        subtitle: Text('ออกจากระบบ กลับไปหน้า login'),
        onTap: () => confirmSignout(),
      );

  UserAccountsDrawerHeader showHeaderDrawer() {
    return UserAccountsDrawerHeader(
      decoration: MyStyle().myBoxDecoration('garage.jpg'),
      currentAccountPicture: MyStyle().showLogo(),
      accountName: Text('Customer'),
      accountEmail: Text('$userName'),
    );
  }

  Future<Null> confirmSignout() async {
    showDialog(
      context: context,
      builder: (context) => SimpleDialog(
        title: Text('Do you want to log-out ?'),
        children: <Widget>[
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceAround,
            children: <Widget>[
              FlatButton(
                onPressed: () {
                  Navigator.pop(context);
                  signOutProcess(context);
                },
                child: Text('Yes'),
              ),
              FlatButton(
                onPressed: () => Navigator.pop(context),
                child: Text('No'),
              ),
            ],
          ),
        ],
      ),
    );
  }
}
