import 'dart:convert';
import 'dart:io';
import 'dart:math';

import 'package:dio/dio.dart';
import 'package:flutter/material.dart';
import 'package:google_maps_flutter/google_maps_flutter.dart';
import 'package:image_picker/image_picker.dart';
import 'package:location/location.dart';
import 'package:myproject/screens/Detail.dart';
import 'package:myproject/utility/my_constant.dart';
import 'package:myproject/utility/my_style.dart';
import 'package:myproject/utility/normal_dialog.dart';
import 'package:myproject/model/user_model.dart';
import 'package:myproject/widget/data_list.dart';
import 'package:shared_preferences/shared_preferences.dart';

class AddInform extends StatefulWidget {
  @override
  _AddInformState createState() => _AddInformState();
}

class _AddInformState extends State<AddInform> {
  double lat, lng;
  File file;
  String carType, insChoose, urlImage, eventChoose;
  UserModel userModel;
  var date = DateTime.now();

  List data = List();
  List data2 = List();

  @override
  void initState() {
    super.initState();
    getAllName();
    getAllIns();
    findLatLng();
    readDataUser();
  }

  Future getAllName() async {
    String url = '${MyConstant().domain}/database/getAllData.php?isAdd=true';

    await Dio().get(url).then((value) {
      var result = json.decode(value.data);

      setState(() {
        data = result;
      });
    });
  }

  Future getAllIns() async {
    String url =
        '${MyConstant().domain}/database/getAllInsurance.php?isAdd=true';

    await Dio().get(url).then((value) {
      var result = json.decode(value.data);

      setState(() {
        data2 = result;
      });
    });
  }

  Future<Null> findLatLng() async {
    LocationData locationData = await findLocationData();
    setState(() {
      lat = locationData.latitude;
      lng = locationData.longitude;
    });
  }

  Future<LocationData> findLocationData() async {
    Location location = Location();
    try {
      return location.getLocation();
    } catch (e) {
      return null;
    }
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
    return Scaffold(
        appBar: AppBar(
          title: Text('แจ้งเหตุการณ์ไปยัง admin'),
        ),
        body: SingleChildScrollView(
          child: Column(
            children: <Widget>[
              MyStyle().mySizedBox(),
              eventType(),
              MyStyle().mySizedBox(),
              insType(),
              MyStyle().mySizedBox(),
              carForm(),
              MyStyle().mySizedBox(),
              groupImage(),
              MyStyle().mySizedBox(),
              lat == null ? MyStyle().showProgress() : showMap(),
              MyStyle().mySizedBox(),
              saveButton(),
            ],
          ),
        ));
  }

  Widget eventType() => Row(
        mainAxisAlignment: MainAxisAlignment.center,
        children: <Widget>[
          Container(
            width: 250.0,
            child: Row(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                DropdownButton(
                  value: eventChoose,
                  hint: Text('เลือกเหตุการณ์'),
                  items: data.map(
                    (list) {
                      return DropdownMenuItem(
                        child: Text(list['eventName']),
                        value: list['eventName'],
                      );
                    },
                  ).toList(),
                  onChanged: (value) {
                    setState(() {
                      eventChoose = value;
                    });
                  },
                ),
              ],
            ),
          ),
        ],
      );

  Widget insType() => Row(
        mainAxisAlignment: MainAxisAlignment.center,
        children: <Widget>[
          Container(
            width: 250.0,
            child: Row(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                DropdownButton(
                  value: insChoose,
                  hint: Text('เลือกบริษัทประกัน'),
                  items: data2.map(
                    (list) {
                      return DropdownMenuItem(
                        child: Text(list['name']),
                        value: list['name'],
                      );
                    },
                  ).toList(),
                  onChanged: (value) {
                    setState(() {
                      insChoose = value;
                    });
                  },
                ),
              ],
            ),
          ),
        ],
      );

  Widget carForm() => Row(
        mainAxisAlignment: MainAxisAlignment.center,
        children: <Widget>[
          Container(
              width: 250.0,
              child: TextField(
                maxLength: 20,
                onChanged: (value) => carType = value.trim(),
                decoration: InputDecoration(
                  labelText: 'ยี่ห้อรถยนต์',
                  prefixIcon: Icon(Icons.car_repair),
                  border: OutlineInputBorder(),
                ),
              ))
        ],
      );

  Widget saveButton() {
    return Container(
      width: MediaQuery.of(context).size.width,
      child: RaisedButton.icon(
        color: MyStyle().primaryColor,
        onPressed: () {
          if (file == null) {
            normalDialog(context, 'Please insert the picture');
          } else {
            confirmDialog();
          }
        },
        icon: Icon(
          Icons.save,
          color: Colors.white,
        ),
        label: Text(
          'แจ้งเหตุการณ์',
          style: TextStyle(color: Colors.white),
        ),
      ),
    );
  }

  Future<Null> confirmDialog() async {
    showDialog(
      context: context,
      builder: (context) => SimpleDialog(
        title: Text('Confirm your event ?'),
        children: <Widget>[
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceAround,
            children: <Widget>[
              FlatButton(
                onPressed: () {
                  Navigator.pop(context);
                  uploadImage();
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

  Future<Null> uploadImage() async {
    Random random = Random();
    int i = random.nextInt(1000000);
    String nameImage = 'event$i.jpg';

    String url = '${MyConstant().domain}/database/saveFile.php';

    try {
      Map<String, dynamic> map = Map();
      map['file'] =
          await MultipartFile.fromFile(file.path, filename: nameImage);

      FormData formData = FormData.fromMap(map);
      await Dio().post(url, data: formData).then((value) {
        urlImage = '/database/ICS/$nameImage';
        addEvent();
      });
    } catch (e) {}
  }

  Future<Null> addEvent() async {
    String url =
        '${MyConstant().domain}/database/addEvent.php?isAdd=true&date=$date&eventName=$eventChoose&carType=$carType&name=${userModel.name}&telephone=${userModel.telephone}&insurance=$insChoose&urlPicture=$urlImage&lat=$lat&lng=$lng';

    try {
      Response response = await Dio().get(url);

      if (response.toString() == 'true') {
        Navigator.pop(context);
        normalDialog(context, "Inform has sent to admin");
      } else {
        normalDialog(context, "Failed to inform event");
      }
    } catch (e) {}
  }

  Set<Marker> myMarker() {
    return <Marker>[
      Marker(
          markerId: MarkerId('You are here'),
          position: LatLng(lat, lng),
          infoWindow: InfoWindow(
            title: 'คุณอยู่ที่นี่',
            snippet: 'ละติจูด = $lat , ลองติจูด = $lng',
          ))
    ].toSet();
  }

  Container showMap() {
    LatLng latLng = LatLng(lat, lng);
    CameraPosition cameraPosition = CameraPosition(
      target: latLng,
      zoom: 16.0,
    );

    return Container(
      width: 300.0,
      height: 300.0,
      child: GoogleMap(
        initialCameraPosition: cameraPosition,
        mapType: MapType.normal,
        onMapCreated: (controller) {},
        markers: myMarker(),
      ),
    );
  }

  Row groupImage() {
    return Row(
      mainAxisAlignment: MainAxisAlignment.spaceBetween,
      children: <Widget>[
        IconButton(
            icon: Icon(Icons.add_a_photo, size: 36.0),
            onPressed: () => chooseImage(ImageSource.camera)),
        Container(
          width: 250.0,
          child: file == null
              ? Image.asset('assets/images/picture.png')
              : Image.file(file),
        ),
        IconButton(
            icon: Icon(Icons.add_photo_alternate, size: 36.0),
            onPressed: () => chooseImage(ImageSource.gallery)),
      ],
    );
  }

  Future<Null> chooseImage(ImageSource imageSource) async {
    try {
      var object = await ImagePicker.pickImage(
        source: imageSource,
        maxHeight: 800.0,
        maxWidth: 800.0,
      );
      setState(() {
        file = object;
      });
    } catch (e) {}
  }
}
