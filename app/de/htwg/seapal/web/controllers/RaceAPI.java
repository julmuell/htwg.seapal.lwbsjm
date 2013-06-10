package de.htwg.seapal.web.controllers;

import org.codehaus.jackson.JsonNode;
import org.codehaus.jackson.node.ArrayNode;
import org.codehaus.jackson.node.ObjectNode;

import play.libs.Json;
import play.mvc.Controller;
import play.mvc.Result;

import com.google.inject.Inject;

import de.htwg.seapal.utils.logging.ILogger;

public class RaceAPI extends Controller {

	@Inject
	private ILogger logger;

	//@Inject 
	//private IRaceController raceController;

	public Result raceAsJson() {
		
		JsonNode race = generateTestRace();
		
		return ok(race);
	}
	
	private ObjectNode generateTestRace() {
		ObjectNode race = Json.newObject();

		race.put("id", "raceId1");
		race.put("name", "Test race");
		race.put("boatClass", "49ers");
		
		ArrayNode trips = race.putArray("trips");
		trips.add(generateTestTrip(trips, "tripId1", "Test trip 1", 0));
		trips.add(generateTestTrip(trips, "tripId2", "Test trip 2", 0.0025));
		
		ArrayNode controlPoints = race.putArray("controlPoints");
		controlPoints.add(generateTestControlPoint("controlPointId1", 39.9, 50.0, 40.1, 50.0)); // start
		controlPoints.add(generateTestControlPoint("controlPointId2", 41.9, 50.1));
		controlPoints.add(generateTestControlPoint("controlPointId3", 42.1, 51.9));
		controlPoints.add(generateTestControlPoint("controlPointId4", 43.9, 52.0, 44.1, 52.0)); // goal
		
		return race;
	}
	
	private JsonNode generateTestTrip(ArrayNode trips, String id, String name, double offset) {
		ObjectNode trip = Json.newObject();
		trip.put("id", id);
		trip.put("name", name);
		trip.put("boat", generateTestBoat(id + "+boatId1", "Titanic", "GER"));
		ArrayNode waypoints = trip.putArray("waypoints");
		waypoints.add(generateTestWaypoint(id + "-waypointId1", 40.0 + offset, 50.0 - offset, 1000000, null));
		waypoints.add(generateTestWaypoint(id + "-waypointId2", 41.0 + offset, 50.0 - offset, 1010000, null));
		waypoints.add(generateTestWaypoint(id + "-waypointId3", 42.0 + offset, 50.0 - offset, 1020000, "controlPointId2"));
		waypoints.add(generateTestWaypoint(id + "-waypointId4", 42.0 + offset, 51.0 - offset, 1030000, null));
		waypoints.add(generateTestWaypoint(id + "-waypointId5", 42.0 + offset, 52.0 - offset, 1040000, "controlPointId3"));
		waypoints.add(generateTestWaypoint(id + "-waypointId6", 43.0 + offset, 52.0 - offset, 1050000, null));
		waypoints.add(generateTestWaypoint(id + "-waypointId7", 44.0 + offset, 52.0 - offset, 1060000, null));
		return trip;
	}
	
	private JsonNode generateTestBoat(String id, String name, String iocCode) {
		ObjectNode boat = Json.newObject();
		boat.put("id", id);
		boat.put("name", name);
		boat.put("IOCCode", iocCode);
		return boat;
	}
	
	private JsonNode generateTestWaypoint(String id, double lat, double lng, long timestamp, String markPassingId) {
		ObjectNode waypoint = Json.newObject();
		waypoint.put("id", id);
		waypoint.put("lat", lat);
		waypoint.put("lng", lng);
		waypoint.put("timestamp", timestamp);
		waypoint.put("sog", 10.0);
		waypoint.put("markPassing", markPassingId);
		return waypoint;
	}
	
	private JsonNode generateTestControlPoint(String id, double lat1, double lng1){
		ObjectNode controlPoint = Json.newObject();
		controlPoint.put("id", id);
		
		ArrayNode coords = controlPoint.putArray("coords");
		ObjectNode coord1 = Json.newObject();
		coord1.put("lat", lat1);
		coord1.put("lng", lng1);
		coords.add(coord1);
		
		return controlPoint;
	}
	
	private JsonNode generateTestControlPoint(String id, double lat1, double lng1, double lat2, double lng2){
		ObjectNode controlPoint = Json.newObject();
		controlPoint.put("id", id);
		
		ArrayNode coords = controlPoint.putArray("coords");
		ObjectNode coord1 = Json.newObject();
		coord1.put("lat", lat1);
		coord1.put("lng", lng1);
		coords.add(coord1);
		
		ObjectNode coord2 = Json.newObject();
		coord2.put("lat", lat2);
		coord2.put("lng", lng2);
		coords.add(coord2);
		
		return controlPoint;
	}
}