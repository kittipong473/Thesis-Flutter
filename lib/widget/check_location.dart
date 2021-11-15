import 'dart:async';
import 'dart:collection';
import 'dart:convert';

import 'package:dio/dio.dart';
import 'package:flutter/material.dart';
import 'package:google_maps_flutter/google_maps_flutter.dart';
import 'package:location/location.dart';
import 'package:myproject/utility/my_constant.dart';
import 'package:myproject/utility/my_style.dart';

class CheckLocation extends StatefulWidget {
  @override
  _CheckLocationState createState() => _CheckLocationState();
}

class _CheckLocationState extends State<CheckLocation> {
  Map<String, Marker> markers = <String, Marker>{};
  Future<void> _onMapCreated(GoogleMapController controller) async {
    setState(() {
      markers.clear();
      for (int index = 0; index < glatlng.length; index++) {
        glat = double.parse(glatlng[index]['lat']);
        glng = double.parse(glatlng[index]['lng']);
        gName = glatlng[index]['garageName'];
        gdesc = glatlng[index]['description'];
        Marker marker = Marker(
          markerId: MarkerId(gName),
          position: LatLng(glat, glng),
          infoWindow: InfoWindow(
            title: gName,
            snippet: gdesc,
          ),
          icon: BitmapDescriptor.defaultMarkerWithHue(
            BitmapDescriptor.hueAzure,
          ),
        );
        markers[gName] = marker;
      }
      Marker cmarker = Marker(
        markerId: MarkerId('current'),
        position: LatLng(clat, clng),
        infoWindow: InfoWindow(
          title: 'คุณอยู่ที่นี่',
          snippet: 'ละติจูด: $clat , ลองจิจูด: $clng',
        ),
      );
      markers['current'] = cmarker;
    });
  }

  double clat, clng, glat, glng;
  String gName, gdesc;

  List glatlng = List();

  @override
  void initState() {
    super.initState();
    getGarage();
    findLatLng();
  }

  Future getGarage() async {
    String url = '${MyConstant().domain}/database/getAllGarage.php?isAdd=true';

    await Dio().get(url).then((value) {
      var result = json.decode(value.data);

      setState(() {
        glatlng = result;
      });
    });
  }

  Future<Null> findLatLng() async {
    LocationData locationData = await findLocationData();
    setState(() {
      clat = locationData.latitude;
      clng = locationData.longitude;
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

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Location'),
      ),
      body: Stack(
        children: <Widget>[
          clat == null ? MyStyle().showProgress() : showMap(),
        ],
      ),
    );
  }

  Container showMap() {
    LatLng latLng = LatLng(clat, clng);
    CameraPosition cameraPosition = CameraPosition(
      target: latLng,
      zoom: 11.0,
    );

    return Container(
      child: clat == null
          ? MyStyle().showProgress()
          : GoogleMap(
              onMapCreated: _onMapCreated,
              initialCameraPosition: cameraPosition,
              mapType: MapType.normal,
              markers: markers.values.toSet(),
            ),
    );
  }
}
