import 'package:dio/dio.dart';
import 'package:flutter/material.dart';
import 'package:google_maps_flutter/google_maps_flutter.dart';
import 'package:myproject/model/event_model.dart';
import 'package:myproject/utility/my_constant.dart';
import 'package:myproject/utility/my_style.dart';
import 'package:myproject/utility/normal_dialog.dart';

class Detail extends StatefulWidget {

  final EventModel eventModel;
  Detail({Key key, this.eventModel}) : super(key: key);

  @override
  _DetailState createState() => _DetailState();
}

class _DetailState extends State<Detail> {

  String showName;
  EventModel eventModel;

  @override
  void initState() {
    super.initState();
    eventModel = widget.eventModel;
  }

  @override
  Widget build(BuildContext context) {
    if(eventModel.garage == null){
          showName = "ยังไม่มี";
        } else {
          showName = eventModel.garage;
        }
    return Scaffold(
        appBar: AppBar(
          title: Text('รายละเอียดเหตุการณ์ : ${eventModel.name}'),
        ),
        body: SingleChildScrollView(
          child: showEventDetail(),
        ));
  }

  Column showEventDetail() => Column(children: <Widget>[
        MyStyle().mySizedBox(),
        Row(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            MyStyle().showTitle('แจ้งเมื่อวันที่ : ${eventModel.date}'),
          ],
        ),
        MyStyle().mySizedBox(),
        Row(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            MyStyle().showTitle('เบอร์โทรติดต่อ : ${eventModel.telephone}'),
          ],
        ),
        MyStyle().mySizedBox(),
        Row(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            MyStyle().showTitle('ประเภทเหตุการณ์ : ${eventModel.eventName}'),
          ],
        ),
        MyStyle().mySizedBox(),
        Row(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            MyStyle().showTitle('ประเภทรถ : ${eventModel.carType}'),
          ],
        ),
        MyStyle().mySizedBox(),
        Row(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            MyStyle().showTitle('ประกันที่ผูก : ${eventModel.insurance}'),
          ],
        ),
        MyStyle().mySizedBox(),
        Row(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            MyStyle().showTitle('อู่ซ่อมรถที่รับผิดชอบ : $showName'),
          ],
        ),
        MyStyle().mySizedBox(),
        showImage(),
        MyStyle().mySizedBox(),
        showMap(),
        MyStyle().mySizedBox(),
        deleteButton(),
      ]);

  Container showImage() {
    return Container(
      width: 250.0,
      height: 250.0,
      child: Image.network('${MyConstant().domain}${eventModel.urlPicture}'),
    );
  }

  Set<Marker> shopMarker() {
    return <Marker>[
      Marker(
          markerId: MarkerId('eventID'),
          position: LatLng(
            double.parse(eventModel.lat),
            double.parse(eventModel.lng),
          ),
          infoWindow: InfoWindow(
              title: 'คุณอยู่ที่นี่',
              snippet:
                  'ละติจูด = ${eventModel.lat} ,ลองติจูด = ${eventModel.lng}'))
    ].toSet();
  }

  Widget showMap() {
    double lat = double.parse(eventModel.lat);
    double lng = double.parse(eventModel.lng);

    LatLng latLng = LatLng(lat, lng);
    CameraPosition position = CameraPosition(target: latLng, zoom: 16.0);

    return Container(
      padding: EdgeInsets.all(10.0),
      width: 300.0,
      height: 300.0,
      child: GoogleMap(
        initialCameraPosition: position,
        mapType: MapType.normal,
        onMapCreated: (controller) {},
        markers: shopMarker(),
      ),
    );
  }

  Widget deleteButton() {
    return Container(
      width: MediaQuery.of(context).size.width,
      child: RaisedButton.icon(
        color: MyStyle().redColor,
        onPressed: () {
          confirmDialog();
        },
        icon: Icon(
          Icons.auto_delete,
          color: Colors.white,
        ),
        label: Text(
          'Delete Event',
          style: TextStyle(color: Colors.white),
        ),
      ),
    );
  }

  Future<Null> confirmDialog() async {
    showDialog(
      context: context,
      builder: (context) => SimpleDialog(
        title: Text('Are you sure you want to delete this?'),
        children: <Widget>[
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceAround,
            children: <Widget>[
              FlatButton(
                onPressed: () {
                  Navigator.pop(context);
                  deleteData();
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

  Future<Null> deleteData() async {
    String url = '${MyConstant().domain}/database/deleteWhereId.php?isAdd=true&No=${eventModel.no}';

    try {
      Response response = await Dio().get(url);

      if (response.toString() == 'true') {
        normalDialog(context, "Failed to delete event");
      } else {
        Navigator.pop(context);
        normalDialog(context, "Delete event successfully");
      }
    } catch (e) {}
  }
}
