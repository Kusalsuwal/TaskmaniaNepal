@extends('layouts.app')
@section('content')
<div class="container">
    <h1>Choose your Subscription</h1>
    <p>Subscribe now or start a 15-day free trial.</p>

    <div class="row">
        <div class="col-md-6">
          
                @csrf
                <button type="submit" class="btn btn-primary">Subscribe Now</button>
            </form>
        </div>
        <div class="col-md-6">
          
                @csrf
                <button type="submit" class="btn btn-secondary">Start Free Trial</button>
            </form>
        </div>
    </div>
</div>
@endsection
