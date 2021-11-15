import 'dart:convert';

import 'package:dio/dio.dart';
import 'package:flutter/material.dart';
import 'package:myproject/model/user_model.dart';
import 'package:myproject/screens/editUser.dart';
import 'package:myproject/utility/my_constant.dart';
import 'package:myproject/utility/my_style.dart';
import 'package:shared_preferences/shared_preferences.dart';

class InformationList extends StatefulWidget {
  @override
  _InformationListState createState() => _InformationListState();
}

class _InformationListState extends State<InformationList> {
  UserModel userModel;

  @override
  void initState() {
    super.initState();
    readDataUser();
  }

  Future<Null> readDataUser() async {
    SharedPreferences preferences = await SharedPreferences.getInstance();
    String customerID = preferences.getString('customerID');

    String url =
        '${MyConstant().domain}/database/getUserWhereId.php?isAdd=true&customerID=$customerID';
    await Dio().get(url).then((value) {
      var result = json.decode(value.data);
      for (var map in result) {
        setState(() {
          userModel = UserModel.fromJson(map);
        });
      }
    });
  }

  @override
  Widget build(BuildContext context) {
    return Stack(
      children: <Widget>[
        userModel == null ? MyStyle().showProgress() : 
        showInfo(),
        //editButton(),
      ],
    );
  }

  Row editButton() {
    return Row(
      mainAxisAlignment: MainAxisAlignment.end,
      children: <Widget>[
        Column(
          mainAxisAlignment: MainAxisAlignment.end,
          children: <Widget>[
            Padding(
              padding: const EdgeInsets.all(20.0),
              child: FloatingActionButton(
                child: Icon(Icons.edit),
                onPressed: () {
                  routeToEdit();
                },
              ),
            ),
          ],
        ),
      ],
    );
  }

  void routeToEdit() {
    MaterialPageRoute materialPageRoute =
        MaterialPageRoute(builder: (context) => EditUser());
    Navigator.push(context, materialPageRoute).then((value) => readDataUser());
  }

  Widget showInfo() => Column(
        children: <Widget>[
          SizedBox(height: 30.0),
          myLogo(),
          MyStyle().mySizedBox(),
          showAppName(),
          SizedBox(height: 50.0),
          Row(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              MyStyle().showTitle('Username: ${userModel.username}'),
            ],
          ),
          SizedBox(height: 30.0),
          Row(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              MyStyle().showTitle('Name: ${userModel.name}'),
            ],
          ),
          SizedBox(height: 30.0),
          Row(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              MyStyle().showTitle('Telephone: ${userModel.telephone}'),
            ],
          ),
          SizedBox(height: 80.0),
          Row(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              MyStyle().showTitle('Contact Admin :'),
            ],
          ),
          SizedBox(height: 20.0),
          Row(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              MyStyle().showTitle('Email : admin0@email.com'),
            ],
          ),
          SizedBox(height: 10.0),
          Row(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              MyStyle().showTitle('Telephone : 0956492669'),
            ],
          ),
        ],
      );

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
}
