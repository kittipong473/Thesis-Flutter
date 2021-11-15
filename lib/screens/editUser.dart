import 'dart:convert';

import 'package:dio/dio.dart';
import 'package:flutter/material.dart';
import 'package:myproject/model/user_model.dart';
import 'package:myproject/utility/my_constant.dart';
import 'package:myproject/utility/my_style.dart';
import 'package:myproject/utility/normal_dialog.dart';
import 'package:shared_preferences/shared_preferences.dart';

class EditUser extends StatefulWidget {
  @override
  _EditUserState createState() => _EditUserState();
}

class _EditUserState extends State<EditUser> {
  UserModel userModel;
  String name, tel, Oname, Otel;

  @override
  void initState() {
    super.initState();
    readCurrentData();
  }

  Future<Null> readCurrentData() async {
    SharedPreferences preferences = await SharedPreferences.getInstance();
    String customerID = preferences.getString('customerID');

    String url =
        '${MyConstant().domain}/database/getUserWhereId.php?isAdd=true&customerID=$customerID';

    Response response = await Dio().get(url);

    var result = json.decode(response.data);

    for (var map in result) {
      setState(() {
        userModel = UserModel.fromJson(map);
        Oname = userModel.name;
        Otel = userModel.telephone;
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
        appBar: AppBar(
          title: Text('แก้ไขข้อมูล User'),
        ),
        body: SingleChildScrollView(
          child: userModel == null ? MyStyle().showProgress() : showContent(),
        ));
  }

  Widget showContent() => Column(
        children: <Widget>[
          MyStyle().mySizedBox(),
          myLogo(),
          MyStyle().mySizedBox(),
          showAppName(),
          MyStyle().mySizedBox(),
          nameForm(),
          MyStyle().mySizedBox(),
          telephoneForm(),
          SizedBox(height: 100.0),
          editButton(),
        ],
      );

  Widget editButton() => Container(
        width: MediaQuery.of(context).size.width,
        child: RaisedButton.icon(
          color: MyStyle().primaryColor,
          onPressed: () => confirmDialog(),
          icon: Icon(
            Icons.edit,
            color: Colors.white,
          ),
          label: Text(
            'แก้ไขเสร็จสิ้น',
            style: TextStyle(color: Colors.white),
          ),
        ),
      );

  Future<Null> confirmDialog() async {
    showDialog(
      context: context,
      builder: (context) => SimpleDialog(
        title: Text('Confirm your information ?'),
        children: <Widget>[
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceAround,
            children: <Widget>[
              FlatButton(
                onPressed: () {
                  Navigator.pop(context);
                  editThread();
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

  Future<Null> editThread() async {
    String customerID = userModel.customerID;
    String url =
        '${MyConstant().domain}/database/editUserWhereId.php?isAdd=true&customerID=$customerID&name=$name&telephone=$tel';
    Response response = await Dio().get(url);
    if (response.toString() == 'true') {
      Navigator.pop(context);
    } else {
      normalDialog(context, 'Update failed, try again');
    }
  }

  Widget nameForm() => Row(
        mainAxisAlignment: MainAxisAlignment.center,
        children: <Widget>[
          Container(
            margin: EdgeInsets.only(top: 16.0),
            width: 250.0,
            child: TextFormField(
              onChanged: (value) => name = value.trim(),
              initialValue: Oname,
              decoration: InputDecoration(
                prefixIcon: Icon(
                  Icons.face,
                  color: MyStyle().darkColor,
                ),
                border: OutlineInputBorder(),
                labelText: 'Customer Name',
              ),
            ),
          ),
        ],
      );

  Widget telephoneForm() => Row(
        mainAxisAlignment: MainAxisAlignment.center,
        children: <Widget>[
          Container(
            margin: EdgeInsets.only(top: 16.0),
            width: 250.0,
            child: TextFormField(
              onChanged: (value) => tel = value.trim(),
              initialValue: Otel,
              decoration: InputDecoration(
                prefixIcon: Icon(
                  Icons.local_phone,
                  color: MyStyle().darkColor,
                ),
                border: OutlineInputBorder(),
                labelText: 'Tel. Nuber',
              ),
            ),
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
