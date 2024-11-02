# Update Q4-2024 + Q1-2025
---
### Allgemein Image
---
- PHP 8.3.3 
- Ubuntu 22.04
- Aktuellste Updates

---
### Neue Features
---
- Startseite überarbeitet 
    - Astronomisches Wetter
    - Wettervorhersage nach Zambretti
    - Fünf Tages Vorhersage mit Chart Darstellung
    - Athmosphärendaten
        - Berechnung Theta E
           Theta E berechnung zur Vorhersage von möglichen Gewittern oder Unwettern innerhalb von 12-24 Stunden
            - verschieden farbige Warnlevel, je nach dem wie hoch Theta-E ist
        - Wolken und Höhenwetter
            - Wolkenhöhe über Grund(Berechnung Kondensationsniveau)
            - Wolkenbasistemperatur
            - 1500m Höhe Temperatur
            - 3000m Höhe Temperatur
            - 5500m Höhe Temperatur
            - Nullgradgrenze ab Wolkenbasis
            - Nullgradgrenze ab grund
            - Berechnung der Parameter mit dem trockendiabetischen Temperaturgradienten(bis Kondensationsniveau) und dem feuchtdiabetischen Temperaturgradienten (ab Kondensationsniveau)
    - Tageswerte
    - Modernisierung der Ausgabe der Jahreswerte, Monatsmittel etc.
    - Teilweise Implementierung zur Nutzung einer .ini Datei, dieses Feature wird in den nächsten Updates weiter ausgebaut
    - Neue Funktion zur Berechnung des Niederschlags
    - Meldung, wenn Extramodule nicht aktiv sind. 
    

---
### Entfernte Elemente
---
- Link heutiger Tag
- Eigene Seite Tageswerte
- Einige Scripts
- Scripte für Berechnung des Regens

---
### PHP
---

- Auslagerung vielfach genutzer Querys in eigenen Ordner
- Auslagerung von Altcode in mehrfach benutzbare Funktionen mit Rückgabewert
- <span style="color:red">neue Funktionen:</span>
    - saturationVaporPressure() | Spezifische Dampdruckberechnung der Luftmasse
    - calculateThetaE() return $theta_e_celsius; | Berechnung von Theta-E
    - zambrettiForecaster | Erstellung einer Wettervorhersage für 12-24 Stunden
    - calc_cloudbase($hc); | Berechnung Wolkenuntergrenze; gibt Wolkenuntergrenze alt Integer zurück
    - calc_cloud_downtemp($hc, $gerechnete_temperatur) | Berechnet Temperatur an der Wolkenuntergrenze | gibt Temperatur an der Wolkenuntergrenze als Integer zurück
    - calc_freezinglevel_above_clBase($wolkenbasistemperatur) | Berechnet Nullgradgrenze ab Wolkenuntergrenze | gibt Wert als Integer zurück
    - calc_freezinglevel_fromGround($freezinglevel_above_clBase, $hc) | Berechnet Nullgradgrenze ab Grund | gibt Wert als Integer zurück
    - calc_minus5degrees_isotherme($wolkenbasistemperatur,$hc) | Berechnet die Höhe der -5 Grad Isotherme 
    - calc_minus10degrees_isotherme($wolkenbasistemperatur,$hc) | Berechnet die Höhe der -10 Grad Isotherme 
    - calc_1500m_temp($gerechnete_temperatur,$wolkenbasistemperatur,$hc) | Berechnet die 850hpa Temperatur
    - calc_3000m_temp($gerechnete_temperatur,$wolkenbasistemperatur,$hc) | Berechnet die 700hpa Temperatur
    - calc_5500m_temp($gerechnete_temperatur,$wolkenbasistemperatur,$hc) | Berechnet die 500hpa Temperatur
    - berechneMonatlichenNiederschlag($pdo) | Errechnet den Monatlichen Niederschlag
    - check_uv_module_avail($uv_module) | Überprüfung, ob UV Modul in webapp.ini aktiv ist
    - check_weather_forecast_avail($weatherforecast_module) | Überprüfung, ob Openweather Modul in webapp.ini aktiv ist. Überprüfung von API Zugang etc. in Arbeit
    - check_airpressure_avail($airpressure_module) | Überprüfung, ob Openweather Modul in webapp.ini aktiv ist. 
 
- <span style="color:red">neue PHP Module:</span>
    - theta-e.php
    - zambretti-forecast.php
    - wolkenbasis.php
- <span style="color:red">aktualisierte PHP Module:</span>
    - Funktion Windchill; | Einsetzung der neuen Berechungsformel 
    - Funktion calculatePressureTrend; | Errechnet die Luftdruckveränderung in den letzten 12 Stunden

---
### Datenbank
---
- Datenbankupdate auf V3

---
### CSS
---
- neues CSS Script für Chartjs

---
###Features in Erstellung
---

- Farbige Unterlegung der ausgegebenen Jahreswerte
- Kombinierter Graph warme/heiße/Wüstentage aktuelles jahr und Vorjahr ausklappbar über Modal
- Tabelle Jahreswerte um Spalte "Werte vergleichen" erweitert
- Tabelle Jahreswerte um Spalte "Werte vergleichen" erweitert

---
###Stand 30.10.2024
