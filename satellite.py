import datetime
import time
from datetime import timedelta
from skyfield.api import load, Topos, EarthSatellite, wgs84, utc

TLE_FILE = "https://celestrak.com/NORAD/elements/active.txt"

satellites_name = []
t_events_list = []
list_of_times = []
planning_list = []

satellites_name.append("NOAA 18")
satellites_name.append("NOAA 19")
satellites_name.append("NOAA 20")

SATELLITES_COUNT = len(satellites_name)

satellites = load.tle(TLE_FILE)

_sats_by_name = {sat.name: sat for sat in satellites.values()}
satellites_param = []
for i in satellites_name:
    satellites_param.append(_sats_by_name[i])


#############################################

class t_events:
    def __init__(self, t, events):
        self.t = t
        self.events = events


class set_culm_rise:
    def __init__(self, rise, culm, sett, index):
        self.rise = rise
        self.culm = culm
        self.sett = sett
        self.index = index

class time_and_satell_index:
    def __init__(self, time, index):
        self.time = time
        self.index = index

#############################################


bluffton = wgs84.latlon(+60.006379, +30.379293)
ts = load.timescale()
t0 = ts.utc(2022, 4, 3, 5)
t1 = ts.utc(2022, 4, 3, 23)

for i, val in enumerate(satellites_param):
    t_i, events_i = val.find_events(bluffton, t0, t1, altitude_degrees=30.0)
    t_events_list.append(t_events(t_i, events_i))

ti_set = ts.now()
ti_culm = ts.now()
flag = False
step = 0

for i, val in enumerate(t_events_list):
    for ti, event in zip(val.t, val.events):
        difference = satellites_param[i] - bluffton
        if step == 0:
            ti_set = ti
        elif step == 1:
            ti_culm = ti
            topocentric = difference.at(ti_culm)
            alt, az, distance = topocentric.altaz()
            # print(alt.degrees)
            if (alt.degrees < 50):
                flag = True
        elif flag == False:
            list_of_times.append(set_culm_rise(ti_set, ti_culm, ti, i))
        if step == 2: flag = False
        step = 0 if step == 2 else step + 1


def seconds_in_date(t):
    return t.utc.hour * 60 * 60 + t.utc.minute * 60 + t.utc.second

list_of_times.sort(key=lambda s_c_s: seconds_in_date(s_c_s.rise))

# for i in list_of_times:
#     print(satellites_name[i.index], ":",
#           i.rise.utc_strftime('%Y %b %d %H:%M:%S'),
#           i.culm.utc_strftime('%Y %b %d %H:%M:%S'),
#           i.sett.utc_strftime('%Y %b %d %H:%M:%S'))

for i in list_of_times:
    curr = i.rise
    while seconds_in_date(curr) <= seconds_in_date(i.sett):
        curr += timedelta(seconds = 1)
        planning_list.append(time_and_satell_index(curr, i.index))

for i in planning_list:
    print(satellites_name[i.index], ":", i.time.utc_strftime('%Y %b %d %H:%M:%S'))