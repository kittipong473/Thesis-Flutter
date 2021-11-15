import 'dart:convert';

import 'package:dio/dio.dart';
import 'package:flutter/material.dart';
import 'package:myproject/model/event_model.dart';
import 'package:myproject/model/user_model.dart';
import 'package:myproject/screens/Detail.dart';
import 'package:myproject/utility/my_constant.dart';
import 'package:myproject/utility/my_style.dart';
import 'package:myproject/utility/normal_dialog.dart';
import 'package:myproject/widget/add_inform.dart';
import 'package:shared_preferences/shared_preferences.dart';

class DataList extends StatefulWidget {
  @override
  _DataListState createState() => _DataListState();
}

class _DataListState extends State<DataList> {
  EventModel eventModel;
  UserModel userModel;
  String eventName, dateTime, name, showName;
  bool loadStatus = true;
  bool status = true;

  List event = List();

  @override
  void initState() {
    super.initState();
    readDataUser();
    readDataEvent();
  }

  Future<Null> readDataEvent() async {

    if (event.length != 0){
      event.clear();
    }

    SharedPreferences preferences = await SharedPreferences.getInstance();
    String name = preferences.getString('name');

    String url = '${MyConstant().domain}/database/getAllEventWhereName.php?isAdd=true&name=$name';

    await Dio().get(url).then((value) {
      setState(() {
        loadStatus = false;
      });
      if (value.toString() != 'null') {
        var result = json.decode(value.data);
        for (var map in result) {
          eventModel = EventModel.fromJson(map);
          setState(() {
              event.add(eventModel);
          });
        }
      } else {
        setState(() {
          status = false;
        });
      }
    });
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
        event.length == 0
            ? MyStyle().titleCenter('ยังไม่มีการแจ้งเหตุการณ์')
            : showEventInfo(),
        addButton(),
      ],
    );
  }

  Widget showEventInfo() => ListView.builder(
      
      itemCount: event.length,
      itemBuilder: (context, index) {
        if(event[index].garage == null){
          showName = "ยังไม่มีอู่รับเรื่อง";
        } else {
          showName = event[index].garage;
        }
        return ListTile(
          leading: Text(event[index].status,style: TextStyle(fontWeight: FontWeight.bold,fontSize: 20),),
          title: Text(event[index].eventName,style: TextStyle(fontSize: 20),),
          subtitle: Text(showName,style: TextStyle(fontSize: 20),),
          trailing: RaisedButton(
              onPressed: () {
                MaterialPageRoute route = MaterialPageRoute(
                  builder: (context) => Detail(eventModel: event[index]),
                );
                Navigator.push(context, route).then((value) => readDataEvent());
              },
              child: Text('Detail')),
        );
      });

  Row addButton() {
    return Row(
      mainAxisAlignment: MainAxisAlignment.end,
      children: <Widget>[
        Column(
          mainAxisAlignment: MainAxisAlignment.end,
          children: <Widget>[
            Padding(
              padding: const EdgeInsets.all(20.0),
              child: FloatingActionButton(
                child: Icon(Icons.add_circle_outline),
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
        MaterialPageRoute(builder: (context) => AddInform());
    Navigator.push(context, materialPageRoute).then((value) => readDataEvent());
  }
}
