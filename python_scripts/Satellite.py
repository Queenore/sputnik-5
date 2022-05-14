import datetime
import time
import logging
import skyfield.positionlib as poslib
import serial.tools.list_ports
import os
from datetime import timedelta
from skyfield.api import load, Topos, EarthSatellite, wgs84, utc

TLE_FILE = "https://celestrak.com/NORAD/elements/active.txt"

satellites_name = []

satellites_name.append("NOAA 18")
satellites_name.append("NOAA 19")
satellites_name.append("NOAA 20")

com_port_conn_name = '/dev/pts/1'

SATELLITES_COUNT = len(satellites_name)

logging.basicConfig(filename="sputnik.log", level=logging.INFO)

#############################################

class tEvents:
    def __init__(self, t, events):
        self.t = t
        self.events = events


class setCulmRise:
    def __init__(self, rise, culm, set, alt, az, distance, index):
        self.rise = rise
        self.culm = culm
        self.set = set
        self.alt = alt
        self.az = az
        self.distanse = distance
        self.index = index


class planningTime:
    def __init__(self, time, alt, az, distance, index):
        self.time = time
        self.alt = alt
        self.az = az
        self.distanse = distance
        self.index = index

#############################################

while True:

    satellites = load.tle(TLE_FILE)
    _sats_by_name = {sat.name: sat for sat in satellites.values()}
    satellites_param = []

    for i in satellites_name:
        satellites_param.append(_sats_by_name[i])

    bluffton = wgs84.latlon(+60.006379, +30.379293)
    ts = load.timescale()
    t0 = ts.now()
    t1 = t0 + timedelta(hours=20)
    t_events_list = []

    for i, val in enumerate(satellites_param):
        t_i, events_i = val.find_events(bluffton, t0, t1, altitude_degrees=30.0)
        t_events_list.append(tEvents(t_i, events_i))

    temp_list_of_times = []
    ti_rise = ts.now()
    ti_culm = ts.now()
    temp_alt, temp_az, temp_distance = poslib.Angle, poslib.Angle, poslib.Distance
    culm_degrees_flag = False
    step = 0

    for i, val in enumerate(t_events_list):
        for ti, event in zip(val.t, val.events):
            if step == 0:
                ti_rise = ti
            elif step == 1:
                ti_culm = ti
                difference = satellites_param[i] - bluffton
                topocentric = difference.at(ti_culm)
                temp_alt, temp_az, temp_distance = topocentric.altaz()
                if (temp_alt.degrees < 50):
                    culm_degrees_flag = True
            elif culm_degrees_flag == False:
                temp_list_of_times.append(setCulmRise(ti_rise, ti_culm, ti, temp_alt, temp_az, temp_distance, i))
            if step == 2: culm_degrees_flag = False
            step = 0 if step == 2 else step + 1

    temp_list_of_times.sort(key=lambda it: it.rise.tt)
    list_of_times = []

    for i, val in enumerate(temp_list_of_times):
        if i == 0:
            list_of_times.append(val)
        else:
            last_elem = list_of_times[len(list_of_times) - 1]
            if (last_elem.rise.tt > val.rise.tt and last_elem.rise.tt < val.set.tt or
                    last_elem.set.tt > val.rise.tt and last_elem.set.tt < val.set.tt):
                if (last_elem.alt.degrees < val.alt.degrees):
                    list_of_times.remove(last_elem)
                    list_of_times.append(val)
            else:
                list_of_times.append(val)

    planning_list = []

    for i in list_of_times:
        print(satellites_name[i.index], "-> rise:",
              i.rise.utc_strftime('%Y %b %d %H:%M:%S'),
              "; culmination:", i.culm.utc_strftime('%Y %b %d %H:%M:%S'),
              "; set:", i.set.utc_strftime('%Y %b %d %H:%M:%S'))
        # logging.info(satellites_name[i.index] + " -> rise: " + i.rise.utc_strftime('%Y %m %d %H:%M:%S')
        #           + " ; culmination: " + i.culm.utc_strftime('%Y %m %d %H:%M:%S') + " ; set: " +
        #           i.set.utc_strftime('%Y %m %d %H:%M:%S'))

        curr = i.rise
        while curr.tt <= i.set.tt:
            curr += timedelta(seconds=1)
            difference = satellites_param[i.index] - bluffton
            topocentric = difference.at(curr)
            temp_alt, temp_az, temp_distance = topocentric.altaz()
            planning_list.append(planningTime(curr, temp_alt, temp_az, temp_distance, i.index))

    # for i in planning_list:
    #     print(satellites_name[i.index], "::", i.time.utc_strftime('%Y %b %d %H:%M:%S'),
    #           ";alt =", f"{i.alt.degrees:.{6}f}", "; az =", f"{i.az.degrees:.{6}f}")

    for val in planning_list:
        curr_time = ts.now()
        time_to_sleep = val.time.utc_datetime() - curr_time.utc_datetime()
        # logging.info("curr time : " + curr_time.utc_strftime('%Y %m %d %H:%M:%S') +
        #           " | sleep time : " + str(time_to_sleep.seconds) + " seconds or " +
        #           str(time_to_sleep.microseconds) + " microseconds")
        comnd = 'W' + str(int(val.az.degrees)) + ' ' + str(int(val.alt.degrees))
        echo_comnd = bytes('echo ' + comnd + ' > ' + com_port_conn_name, encoding='utf-8')
        os.system(echo_comnd)
        print('send command to com port(' + com_port_conn_name + '): ' + comnd)
        print("curr time :", curr_time.utc_strftime('%Y %b %d %H:%M:%S'),
              "| sleep time :", time_to_sleep.seconds, "seconds or", time_to_sleep.microseconds, "microseconds")
        time.sleep(time_to_sleep.seconds)
        #######
        # logging.info("time after sleep : " + val.time.utc_strftime('%Y %m %d %H:%M:%S'))
        print("time after sleep :", val.time.utc_strftime('%Y %b %d %H:%M:%S'), "\n------------------------")
        #######
