class EventModel {
  String no;
  String date;
  String eventName;
  String carType;
  String name;
  String telephone;
  String insurance;
  String urlPicture;
  String lat;
  String lng;
  String garage;
  String status;

  EventModel(
      {this.no,
      this.date,
      this.eventName,
      this.carType,
      this.name,
      this.telephone,
      this.insurance,
      this.urlPicture,
      this.lat,
      this.lng,
      this.garage,
      this.status});

  EventModel.fromJson(Map<String, dynamic> json) {
    no = json['No'];
    date = json['date'];
    eventName = json['eventName'];
    carType = json['carType'];
    name = json['name'];
    telephone = json['telephone'];
    insurance = json['insurance'];
    urlPicture = json['urlPicture'];
    lat = json['lat'];
    lng = json['lng'];
    garage = json['garage'];
    status = json['status'];
  }

  Map<String, dynamic> toJson() {
    final Map<String, dynamic> data = new Map<String, dynamic>();
    data['No'] = this.no;
    data['date'] = this.date;
    data['eventName'] = this.eventName;
    data['carType'] = this.carType;
    data['name'] = this.name;
    data['telephone'] = this.telephone;
    data['insurance'] = this.insurance;
    data['urlPicture'] = this.urlPicture;
    data['lat'] = this.lat;
    data['lng'] = this.lng;
    data['garage'] = this.garage;
    data['status'] = this.status;
    return data;
  }
}
