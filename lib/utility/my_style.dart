import 'package:flutter/material.dart';

class MyStyle {
  Color redColor = Colors.red.shade400;
  Color darkColor = Colors.blue.shade900;
  Color primaryColor = Colors.blue.shade300;

  Widget showProgress() {
    return Center(
      child: CircularProgressIndicator(),
    );
  }

  Widget titleCenter(String string) {
    return Center(
      child: Text(
        string,
        style: TextStyle(
          fontSize: 24.0,
          fontWeight: FontWeight.bold,
        ),
      ),
    );
  }

  SizedBox mySizedBox() => SizedBox(
        width: 8.0,
        height: 16.0,
      );

  Text showTitle(String title) => Text(title,
      style: TextStyle(
        fontSize: 24.0,
        color: Colors.blue.shade900,
        fontWeight: FontWeight.bold,
      ));

  Text showTitle2(String title) => Text(title,
      style: TextStyle(
        fontSize: 18.0,
        color: Colors.blue.shade900,
      ));

  BoxDecoration myBoxDecoration(String namePic) {
    return BoxDecoration(
      image: DecorationImage(
          image: AssetImage('assets/images/$namePic'), fit: BoxFit.cover),
    );
  }

  Container showLogo() {
    return Container(
        width: 120.0, child: Image.asset('assets/images/mechanic.png'));
  }

  MyStyle();
}
