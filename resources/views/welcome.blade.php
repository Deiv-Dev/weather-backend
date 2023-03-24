<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
      <title>Weather Forecast Recomendations</title>
   </head>
   <body>
      <form method="POST" action="{{ route('processForm') }}">
      @csrf
      <h1>Weather information is provided from <a href="https://api.meteo.lt/">Meteo.lt</a></h1>
      <label for="city">Enter city to get clothes recommendation:</label>
      <input type="text" id="city" name="city" list="cities" required maxlength="25">
      <datalist id="cities">
         @foreach ($cityNames as $city)
         <option value={{ $city }}>{{$city}}
         @endforeach
      </datalist>
      <button type="submit">Submit</button>
      @if(isset($recommendation) && !empty($recommendation))
      <table>
         <thead>
            <tr>
               <th>City</th>
               <th>Date</th>
               <th>Weather</th>
               <th>Recommendations</th>
            </tr>
         </thead>
         <tbody>
            @foreach($recommendation as $weather)
            <tr>
               <td>{{ $weather['name'] }}</td>
               <td>{{ $weather['forecastTimeUtc'] }}</td>
               <td>{{ $weather['conditionCode'] }}</td>
               <td>
                  <ul>
                     @if(!empty($weather['recommendations']))
                     @foreach($weather['recommendations'] as $recommendation)
                     <li>
                        {{ $recommendation['name'] }} <br> SKU:{{ $recommendation['sku'] }} <br> Price:€{{ $recommendation['price'] }} 
                     </li>
                     @endforeach
                     @else
                     No recomendations found
                     @endif
                  </ul>
               </td>
            </tr>
            @endforeach
         </tbody>
      </table>
      @elseif(empty($recommendation))
      <p>NO DATA AVAILABLE</p>
      @endif
   </body>
</html>